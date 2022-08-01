def max_heapify(data, heapsize, i):
    max = i
    left = 2*i
    right = (2*i) + 1

    if left < heapsize and data[left] > data[max]:
        max = left
    if right < heapsize and data[right] > data[max]:
        max = right
    
    if max != i:
        data[max], data[i] = data[i], data[max]
        max_heapify(data, heapsize, max)


def build_max_heap(data, heapsize):
    for i in range(heapsize // 2 - 1, -1, -1):
        max_heapify(data, heapsize, i)


def heapsort(data):
    heapsize = len(data)
    build_max_heap(data, heapsize)
    for i in range(heapsize-1, 0, -1):
        data[0], data[i] = data[i], data[0]
        max_heapify(data, i, 0)
    return data


def main():
    data = [5, 6, 1, 2]
    heapsort(data)
    print(data)


if __name__ == '__main__':
    main()


'''
Funzionamento

HEAPSORT
    heapsize = 4
    build_max_heap([5, 6, 1, 2], 4)
        1° ciclo:
        max_heapify([5, 6, 1, 2], 4, 1)
            max = 1
            left = 2
            right = 3
            il valore massimo si trova già in max, quindi non avviene nessuno scambio
        2° ciclo
        max_heapify([5, 6, 1, 2], 4, 0)
            max = 0
            left = 0
            right = 1
            Il valore massimo si trova in right, quindi
            max = right
            data[1], data[0] = data[0], data[1]
            max_heapify([6, 5, 1, 2], 4, 1)
                max = 1
                left = 2
                right = 3
                il valore massimo è già in max, quindi non avviene nessuno scambio
    1° ciclo:
        data[0], data[3] = data[3], data[0]
        max_heapify([2, 5, 1, 6], 3, 0)
            max = 0
            left = 0
            right = 1
            il valore massimo è in right
            max = right
            avviene lo scambio tra max e i
            data[1] = data[0], data[0], data[1]
            l'array diventa [5, 2, 1, 6]
            max_heapify([5, 2, 1, 6], 3, 1
            max = 1
            left = 2
            right = 3
            il valore massimo sarebbe su 3, però 3 = 3, e non 3 < 3
    2° ciclo
        data[0], data[2] = data[2], data[0]
        max_heapify([1, 2, 5, 6], 2, 0)
        max = 0
        left = 0
        right = 1
        il valore massimo è su right, quindi
        max = right
        e poi avviene lo scambio
        data[1], data[0] = data[0], data[1]
        max_heapify([2, 1, 5, 6], 2, 1)
        max = 1
        left = 2
        right = 3
        sia left che right sono fuori da heapsize
    3° ciclo
        data[0], data[1] = data[1], data[0]
        max_heapify([1, 2, 5, 6], 1, 0)
        max = 0
        left = 0
        right = 1
        Il valore massimo sarebbe su right, però è fuori dall'heapsize, quindi non avviene nessuno scambio
    Viene restituito l'array ordinato [1, 2, 5, 6]
    
'''
