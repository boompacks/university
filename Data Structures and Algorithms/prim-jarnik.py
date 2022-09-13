def min_pop(queue):
    w, u, v = queue[0]
    for tmpw, tmpu, tmpv in queue:
        if tmpw < w:
           w, u, v = tmpw, tmpu, tmpv
    return ((w, u, v))


def prim_jarnik(graph, start):
    X = set()
    MST = dict()
    iedge = 0
    X.add(start)

    while len(X) != len(graph):
        queue = []
        for x in X:
            for k in graph:
                if k not in X and k in graph[x]:
                    queue.append((graph[x][k], x, k))
        w, u, v = min_pop(queue)
        MST[iedge] = (w, u, v)
        X.add(v)
        iedge += 1
    return MST


def main():
    wgraph = {'bwi':{'jfk':184, 'mia':946, 'ord':621}, 'jfk':{'bwi':184, 'pvd':144, 'bos':187, 'ord':740, 'mia':1090}, 'pvd':{'jfk': 144, 'ord': 849}, 
            'bos':{'mia': 1258, 'jfk': 187, 'ord': 867, 'sfo': 2704}, 'mia':{'bwi':946, 'jfk': 1090, 'bos': 1258, 'lax': 2342},
            'ord':{'bos': 867, 'pvd': 849, 'jfk':740, 'bwi': 621, 'sfo': 1846}, 'lax':{'sfo': 337, 'mia': 2342}, 'sfo':{'bos': 2704, 'ord': 1846, 'lax': 337}}
    print(prim_jarnik(wgraph, 'bwi'))


if __name__ == '__main__':
    main()