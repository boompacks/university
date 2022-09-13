def partition(data, leftmark, rightmark):
    pivot = data[rightmark]
    i = leftmark - 1

    for j in range(leftmark, rightmark):
        if data[j] < pivot:
            i += 1
            data[i], data[j] = data[j], data[i]
    data[i+1], data[rightmark] = data[rightmark], data[i+1]
    return i+1


def quicksort(data, leftmark, rightmark):
    if leftmark < rightmark:
        pivot = partition(data, leftmark, rightmark)
        quicksort(data, leftmark, pivot-1)
        quicksort(data, pivot+1, rightmark)


def main():
    data = [5, 6, 1]
    quicksort(data, 0, len(data) - 1)
    print(data)


if __name__ == '__main__':
    main()

'''
Funzionamento
    0 < 2
        pivot = partition([5, 6, 1], 0, 2)
            pivot = 1
            i = -1

            1° ciclo
                if data[0] (5) < pivot (1)
                    non si entra nell'if
            2° ciclo
                if data[1] (6) < pivot (1)
                    non si entra nell'if
            data[0], data[2] = data[2], data[0]
            return 0
            l'array è stato trasformato in [1, 6, 5]

        quicksort(data, 0, -1) leftmark !< rightmark
        quicksort(data, 1, 2)
            pivot = partition([1, 6, 5], 1, 2)
                pivot = 6
                i = 0
                1° ciclo:
                    if data[0] (1) < pivot (5)
                        non si entra nel ciclo
                data[0+1], pivot = pivot, data[0+1]
                return 1
                l'array diventa [1, 5, 6]

            quicksort([1, 5, 6], 1, 0) leftmark !< rightmark
            quicksort([1, 5, 6], 2, 2) leftmark !< rightmark
        Si risale fino alla prima chiamata e si restituisce l'array ordinato
        

PARTITION(A, p, r)
    pivot = A[r]
    i = p-1
    
    for j from p to r
        if A[j] < pivot
            i += 1
            scambia A[i] e A[j]
    scambia A[i+1] con pivot
    return i+1


QUICKSORT(A, p, r)
if p < r
    pivot = partition(A, p, r)
    quicksort(A, p, pivot-1)
    quicksort(A, pivot+1, r)                
'''