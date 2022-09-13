def insertion_sort(data):
    for j in range(1, len(data)):
        key = data[j]
        i = j - 1
        while i >= 0 and data[i] > key:
            data[i+1] = data[i]
            i -= 1
        data[i+1], key = key, data[i+1]
    return data


def main():
    data = [4, 3, 7]
    print(insertion_sort(data))


if __name__ == '__main__':
    main()


'''
Funzionamento:
    1° ciclo:
        key = data[1] ovvero 3
        i = 0
        while 0 >= 0 and data[0] (4) > key (3):
            data[1] = data[0] 
            i -= 1
        [4, 4, 7]
        i ora è -1, quindi non viene eseguito nuovamente il ciclo

        data[0], key =  key, data[0]
    
    l'array è attualmente [3, 4, 7] è già ordinato, però prosegue ancora

    2° ciclo:
        key = data[2] ovvero 7
        i = 1
        while 1 >= 0 and data[1] (4) > key (7)
            non si entra nel ciclo dato che 7 > 4
        data[2], key = key, data[2]  viene praticamente scambiato il 7 con se stesso
    
    termina il ciclo e viene restituito l'array ordinato [3, 4, 7]


PSEUDO-CODICE
INSERTION-SORT(A)
    for j from 2 to length.A
        key = A[j]
        i = j-1
        while i >= 0 and A[i] > key
            scambia A[i+1] con A[i]
            i -= 1
        scambia A[i+1] e key
    return A
'''