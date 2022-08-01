'''
Implementare le seguenti funzioni per gli alberi binari di ricerca:
    is_root(X)
    depth(X)
    height(X)
    is_leaf(X)
    add_root()
    add_child()
    parent(X)
    sibling(X)
    preorder(X)
    inorder(X)
    postorder(X)
    bfs(X)
    count_leaves(X)
    count_one_child(X)
    is_balanced(X)
    minimum(X)
    maximum(X)
    successor(X)
    previous(X)
    insert(X)
    delete(X)
'''
def is_root(T, node):
    return T[node]['parent'] is None


def get_root(T):
    for node in T:
        if T[node]['parent'] is None:
            return node
    return None


def is_leaf(T, node):
    return T[node]['left'] is None and T[node]['right'] is None


def get_familiar(T, node, type):
    if T[node][type] is not None:
        return (T[node][type], T[node])
    return None


def preorder(T, node, visited):
    if node is not None:
        left_child = T[node]['left']
        right_child = T[node]['right']

        visited.append(node)

        if left_child is not None:
            preorder(T, left_child, visited)
        if right_child is not None:
            preorder(T, right_child, visited)
    return visited


def inorder(T, node, visited):
    if node is not None:
        left_child = T[node]['left']
        right_child = T[node]['right']

        
        if left_child is not None:
            inorder(T, left_child, visited)

        visited.append(node)

        if right_child is not None:
            inorder(T, right_child, visited)
    return visited


def postorder(T, node, visited):
    if node is not None:
        left_child = T[node]['left']
        right_child = T[node]['right']

        if left_child is not None:
            postorder(T, left_child, visited)
        if right_child is not None:
            postorder(T, right_child, visited)
        
        visited.append(node)
    return visited


def bfs(T):
    node = get_root(T)
    queue = [node]
    visited = list()

    while len(queue) > 0:
        u = queue.pop(0)
        visited.append(u)
        if T[u]['left'] is not None:
            queue.append(T[u]['left'])
        if T[u]['right'] is not None:
            queue.append(T[u]['right'])
    return visited


def depth(T, node, value):
    if node == value:
        return 0
    elif value > node:
        return 1 + depth(T, T[node]['right'], value)
    else:
        return 1 + depth(T, T[node]['left'], value)


def height(T, node):
    if not node or is_leaf(T, node):
        return 0
    return 1 + max(height(T, T[node]['left']), height(T, T[node]['right']))


def count_leaves(T, node):
    nodes = T.keys()
    if node and node in nodes:
        if not is_leaf(T, node):
            return 1 + count_leaves(T, T[node]['left']) + count_leaves(T, T[node]['right'])
    return 0


def count_one_child(T):
    c = 0
    for node in T.keys():
        if (T[node]['left'] is None and T[node]['right']) or (T[node]['left'] and T[node]['right'] is None):
            c += 1
    return c


def is_balanced(T, node):
    left_subtree = inorder(T, T[node]['left'], [])
    right_subtree = inorder(T, T[node]['right'], [])
    if len(left_subtree) == len(right_subtree):
        return True
    return False


def minimum(T, node):
    while T[node]['left'] is not None:
        node = T[node]['left']
    return node


def maximum(T, node):
    while T[node]['right'] is not None:
        node = T[node]['right']
    return node


def successor(T, node):
    if T[node]['right']:
        return T[node]['right']
    parent = T[node]['parent']
    while parent is not None and node == T[parent]['right']:
        node = parent
        parent = T[node]['parent']
    return parent


def predecessor(T, node):
    nodes = inorder(T, get_root(T), [])
    index = nodes.index(node)

    if index in range(1, len(nodes)):
        return nodes[index-1]
    return None


def insert(T, new_node):
    tmp = get_root(T)
    while tmp is not None:
        new_node_parent = tmp
        if tmp > new_node:
            tmp = T[tmp]['left']
        else:
            tmp = T[tmp]['right']
    T[new_node] = {'parent':new_node_parent, 'left':None, 'right':None}
    if new_node > new_node_parent:
        T[new_node_parent]['right'] = new_node
    else:
        T[new_node_parent]['left'] = new_node


def transplant(T, old, new):
    oldparent = T[old]['parent']
    if oldparent is None:
        if T[old]['right']:
            T[new]['right'] = T[old]['right']
        if T[old]['left']:
            T[new]['left'] = T[old]['left']
    elif old == T[oldparent]['left']:
        T[oldparent]['left'] = new
    else:
        T[oldparent]['right'] = new
    
    if new is not None:
        T[new]['parent'] = oldparent
    del T[old]


def delete(T, node):
    if T[node]['right'] is None:
        transplant(T, node, T[node]['left'])
    elif T[node]['left'] is None:
        transplant(T, node, T[node]['right'])
    else:
        node_min = minimum(T, node)
        if T[node]['right'] != node_min:
            transplant(T, node_min, T[node_min]['right'])
            T[node_min]['right'] = T[node]['right']
            T[T[node_min]['right']]['parent'] = node_min
        transplant(T, node_min, T[node_min]['left'])
        T[node_min]['left'] = T[node]['left']
        T[T[node_min]['left']]['parent'] = node_min


def search(T, node):
    u = get_root(T)
    while u is not None:
        if u == node:
            return (u, T[u])
        elif u > node:
            u = T[u]['left']
        else:
            u = T[u]['right']
    return None


def main():
    T = {
        15: {'parent' : None, 'left': 6, 'right': 18 },
        6: {'parent' : 15, 'left': 3, 'right': 7 },
        18: {'parent' : 15, 'left': None, 'right': 20 },
        3: {'parent' : 6, 'left': None, 'right': None },
        7: {'parent' : 6, 'left': None, 'right': None },
        20: {'parent' : 18, 'left': None, 'right': None }
    }

    print(f'15 è radice? {is_root(T, 15)}')    
    print(f'20 è radice? {is_root(T, 20)}')
    print(f'La radice è: {get_root(T)}')

    print(f'15 è foglia? {is_leaf(T, 15)}')    
    print(f'20 è foglia? {is_leaf(T, 20)}')

    print(f"Il figlio sinistro di 15 è: {get_familiar(T, 15, 'left')}")    
    print(f"Il figlio destro di 15 è: {get_familiar(T, 15, 'right')}")    
    print(f"Il parente di 15 è: {get_familiar(T, 15, 'parent')}")    

    print(f'Preorder: {preorder(T, get_root(T), [])}')
    print(f'Inorder: {inorder(T, get_root(T), [])}')
    print(f'Postorder: {postorder(T, get_root(T), [])}')
    print(f'BFS: {bfs(T)}')

    print(f'Profondità di 15: {depth(T, get_root(T), 15)}')
    print(f'Profondità di 3: {depth(T, get_root(T), 3)}')

    print(f'Altezza di 15: {height(T, 15)}')
    print(f'Altezza di 3: {height(T, 3)}')

    print(f'Le foglie nell\'albero sono: {count_leaves(T, get_root(T))}')
    print(f'I nodi che hanno solo un figlio sono: {count_one_child(T)}')

    print(f'L\'albero è bilanciato? {is_balanced(T, 15)}')
    print(f'L\'albero è bilanciato? {is_balanced(T, 6)}')
    print(f'L\'albero è bilanciato? {is_balanced(T, 18)}')

    print(f'Il valore minimo è: {minimum(T, get_root(T))}')
    print(f'Il valore massimo è: {maximum(T, get_root(T))}')

    print(f'Il successore di 15 è: {successor(T, 15)}')
    print(f'Il successore di 6 è: {successor(T, 6)}')
    print(f'Il successore di 20 è: {successor(T, 20)}')

    print(f'Il predecessore di 7 è: {predecessor(T, 7)}')
    print(f'Il predecessore di 20 è: {predecessor(T, 20)}')
    print(f'Il predecessore di 6 è: {predecessor(T, 6)}')
    print(f'Il predecessore di 3 è: {predecessor(T, 3)}')
    print(f'Il predecessore di 15 è: {predecessor(T, 15)}')

    insert(T, 17)
    print(f'Inorder: {inorder(T, 15, [])}')

    delete(T, 20)
    print(f'Inorder: {inorder(T, 15, [])}')
    
    print(search(T, 7)) 
 
    
if __name__ == '__main__':
    main()