def min_pop(queue):
    dist, node = queue[0]
    for tmp_dist, tmp_node in queue:
        if tmp_dist < dist:
            dist, node = tmp_dist, tmp_node
    queue.remove((dist, node))
    return (dist, node)


def dijkstra(graph, start):
    distances = {i:float('inf') for i in graph.keys()}
    distances[start] = 0
    queue = [(0, start)]

    while len(queue) > 0:
        curr_dist, curr_node = min_pop(queue)
        for neighbor, weight in graph[curr_node].items():
            distance = curr_dist + weight
            if distance < distances[neighbor]:
                distances[neighbor] = distance
                queue.append((distance, neighbor))
    return distances


def main():
    wgraph = {'bwi':{'jfk':184, 'mia':946, 'ord':621}, 'jfk':{'bwi':184, 'pvd':144, 'bos':187, 'ord':740, 'mia':1090}, 'pvd':{'jfk': 144, 'ord': 849}, 
            'bos':{'mia': 1258, 'jfk': 187, 'ord': 867, 'sfo': 2704}, 'mia':{'bwi':946, 'jfk': 1090, 'bos': 1258, 'lax': 2342},
            'ord':{'bos': 867, 'pvd': 849, 'jfk':740, 'bwi': 621, 'sfo': 1846}, 'lax':{'sfo': 337, 'mia': 2342}, 'sfo':{'bos': 2704, 'ord': 1846, 'lax': 337}}
    print(dijkstra(wgraph, 'bwi'))


if __name__ == '__main__':
    main()


'''
RELAX(u, v, w)
if v.w > u.w + w(u, v):
    v.w = u.w + w(u, v)


INITIALIZE(graph, start)
for every node in graph
    node.w = inf
start.w = 0

DIJKSTRA
INITIALIZE
Q = Queue
L = List
Q.Enqueue(start)
while Q.length > 0
    u = POP_MIN(Queue)
    L.append(u)
    for every v in adj[u]:
        Q.Enqueue(v)
        RELAX(u, v, w)

'''