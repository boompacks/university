def counting_sort(A):
    k = max(A)
    B = [0 for i in range(len(A))]
    C = [0 for i in range(k + 1)]

    for j in range(len(A)):
        C[A[j]] += 1
    
    for i in range(1, k+1):
        C[i] += C[i-1]
    
    for j in range(len(A)):
        B[C[A[j]]-1] = A[j]
        C[A[j]] -= 1
    return B

def main():
    A = [3, 6, 2]
    print(counting_sort(A))

if __name__ == '__main__':
    main()


'''
Funzionamento
    k = 6
    B = [0, 0, 0]
    C = [0, 0, 0, 0, 0, 0, 0]

    Con il primo ciclo la C viene trasformata così:
    C = [0, 0, 1, 1, 0, 0, 1]

    Con il secondo ciclo invece così:
    C = [0, 0, 1, 2, 2, 2, 3]

    Con l'ultimo ciclo vengono inseriti gli elementi in B:
    1° ciclo:
        B[1] = 3 
        C = [0, 0, 1, 1, 2, 2, 3]
    2° ciclo
        B[2] = 6
        C = [0, 0, 1, 1, 2, 2, 2]
    3° ciclo
        B[0] = 2
        C = [0, 0, 0, 1, 2, 2, 2]
    Viene restituito l'array B ordinato [2, 3, 6]
'''