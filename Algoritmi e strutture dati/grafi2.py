def create_graph():
    return dict()


def add_node(graph, node):
    graph[node] = []
    return graph


def add_nodes(graph, nodes):
    for node in nodes:
        graph = add_node(graph, node)
    return graph


def add_edge(graph, edge):
    u, v = edge
    if u in graph and v in graph:
        graph[u].append(v)
        graph[v].append(u)
    return graph


def add_edges(graph, edges):
    for edge in edges:
        graph = add_edge(graph, edge)
    return graph


def degree(graph):
    d = dict()
    for node in graph:
        d[node] = len(graph[node])
    return d


def is_complete(graph):
    n = len(graph)
    for node in graph:
        if len(graph[node]) < n-1:
            return False
    return True


def get_edge(graph, edge):
    u, v = edge
    if v in graph[u] and u in graph[v]:
        return True
    return False


def nodes(graph):
    return list(graph.keys())


def edges(graph):
    edges = list()
    for u in graph:
        for v in graph[u]:
            edges.append((u, v))
    return edges


def incident_edges(graph, node):
    return graph[node]


def remove_edge(graph, edge):
    u, v = edge
    if u in graph[v]:
        graph[v].remove(u)
    if v in graph[u]:
        graph[u].remove(v)
    return graph


def remove_vertex(graph, vertex):
    for node in graph.keys():
        if vertex in graph[node]:
            graph[node].remove(vertex)
    del graph[vertex]
    return graph


def main():
    graph = create_graph()

    print(add_nodes(graph, ['a', 'b', 'c']))
    print(add_edges(graph, [('a', 'b'), ('b', 'c')]))

    print(degree(graph))

    print(is_complete(graph))

    print(get_edge(graph, ('a', 'c')))
    print(get_edge(graph, ('a', 'b')))

    print(nodes(graph))
    print(edges(graph))

    print(incident_edges(graph, 'a'))

    print(remove_edge(graph, ('b', 'c')))
    print(remove_vertex(graph, 'c'))


if __name__ == '__main__':
    main()