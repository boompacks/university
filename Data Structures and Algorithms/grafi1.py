def insert_edge(graph, edge):
    u, v = edge
    if u in graph and v in graph:
        graph[u].append(v)
        graph[v].append(u)
    return graph


def remove_node(graph, node):
    for vertex in graph.keys():
        if node in graph[vertex]:
            graph[vertex].remove(node)
    del graph[node]
    return graph


def max_edge(graph):
    return max(len(graph[node]) for node in graph.keys())


def dfs_visit(graph, exploration, node):
    exploration[node] = 0
    for v in graph[node]:
        if exploration[v] == -1:
            dfs_visit(graph, exploration, v)
    exploration[node] = 1


def dfs(graph):
    exploration = {node:-1 for node in graph.keys()}

    for node in graph.keys():
        if exploration[node] == -1:
            dfs_visit(graph, exploration, node)
    return exploration


def bfs(graph, start):
    exploration = {node:-1 for node in graph.keys()}
    stack = [start]
    exploration[start] = 0

    while len(stack) > 0:
        u = stack.pop(0)
        for node in graph[u]:
            if exploration[node] == -1:
                stack.append(node)
                exploration[node] = 0
        exploration[u] = 1
    return exploration


def main():
    graph = {
    "a" : ["b", "c"],
    "b" : ["a", "d"],
    "c" : ["a", "d"],
    "d" : ["b", "c", "e"],
    "e" : ["d"]
    }
    graph = insert_edge(graph, ("e", "b"))
    graph = insert_edge(graph, ("e", "a"))
    graph = remove_node(graph, "c")
    print(graph)
    highest_edges_node = max_edge(graph)
    print(highest_edges_node)
    nodes = dfs(graph)
    print(nodes)
    print(bfs(graph, 'a'))


if __name__ == '__main__':
    main()

'''
PSEUDO-CODICE:

BFS:
stack = Queue
stack.Enqueue(start)

for every node in graph:
    node.color = white

start.color = gray

while stack != null:
    u = stack.Dequeue()
    visited.append(u)
    for each node adj(u)
        if node.color == white:
            node.copor = grau
            Enqueue(node)
    u.color = black
            
return visited


DFS
DFS-VISIT(graph, node):
    node.color = gray
    for v in graph[node]
        if v.color == white
            dfs-visit(graph, v)
    node.color = black


DFS:
    for every node in graph:
        node.color = white
    
    for every node in adj(node)
        if node.color == white
            DFS-VISIT(graph, node)
'''
