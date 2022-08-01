def find_node(clouds, u):
    for index, v in clouds.items():
        if u in v:
            return index


def merge_clouds(clouds, u, v):
    if u < v:
        for adj_node in clouds[v]:
            clouds[u].append(adj_node)
        del clouds[v]
    else:
        for adj_node in clouds[u]:
            clouds[v].append(adj_node)
        del clouds[u]
    return clouds


def kruskal(graph):
    MST = dict()
    clouds = dict()
    edges = list()
    inode = iedge = 0


    for node in graph.keys():
        clouds[inode] = [node]
        inode += 1
    
    for u in graph.keys():
        for v in graph[u]:
            w = graph[u][v]
            if (w, u, v) not in edges or (w, v, u) not in edges:
                edges.append((w, u, v))
    
    for e in sorted(edges):
        w, u, v = e

        ku = find_node(clouds, u)
        kv = find_node(clouds, v)

        if ku != kv:
            clouds = merge_clouds(clouds, ku, kv)
            MST[iedge] = e
            iedge += 1
    return MST


def main():
    wgraph = {'bwi':{'jfk':184, 'mia':946, 'ord':621}, 'jfk':{'bwi':184, 'pvd':144, 'bos':187, 'ord':740, 'mia':1090}, 'pvd':{'jfk': 144, 'ord': 849}, 
            'bos':{'mia': 1258, 'jfk': 187, 'ord': 867, 'sfo': 2704}, 'mia':{'bwi':946, 'jfk': 1090, 'bos': 1258, 'lax': 2342},
            'ord':{'bos': 867, 'pvd': 849, 'jfk':740, 'bwi': 621, 'sfo': 1846}, 'lax':{'sfo': 337, 'mia': 2342}, 'sfo':{'bos': 2704, 'ord': 1846, 'lax': 337}}
    print(kruskal(wgraph))


if __name__ == '__main__':
    main()