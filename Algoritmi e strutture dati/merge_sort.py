def merge(data, s1, s2):
    i = j = 0
    for k in range(len(data)):
        if j == len(s2) or (i < len(s1) and s1[i] < s2[j]):
            data[k] = s1[i]
            i += 1
        else:
            data[k] = s2[j]
            j += 1


def merge_sort(data):
    n = len(data)
    if n < 2:
        return 
    
    mid = n // 2
    s1 = data[0:mid]
    s2 = data[mid:n]
    merge_sort(s1)
    merge_sort(s2)
    merge(data, s1, s2)
    return data


def main():
    data = [4, 7, 3]
    print(merge_sort(data))


if __name__ == '__main__':
    main()



'''
Funzionamento:
    n = 3, che è > 2, quindi si prosegue

    mid = 1
    s1 = data[0:1], ovvero [4]
    s2 = data[1:3], ovvero [7, 3]
    merge_sort(s1), si ferma subito dato che n < 2
    merge_sort(s2)
        n = 2
        mid = 1
        s1 = data[0:1], ovvero [7]
        s2 = data[1:2], ovvero [3]
        merge_sort(s1), si ferma subito dato che n < 2
        merge_sort(s2), si ferma subito dato che n < 2
        merge([7, 3], [7, 3])
            i = j = 0
            1° ciclo:
                viene eseguito l'else, ovvero:
                data[0] = 3
                j += 1
            2° ciclo
                viene eseguito l'if, ovvero:
                data[1] = 7
                i += 1
    merge(data, s1, s2), ovvero merge([4, 7, 3]),[4],[3, 7])
        i = j = 0
        1° ciclo
            viene eseguito l'else, ovvero:
            data[0] = 3
            j += 1
        2° ciclo:
            viene eseguito l'if, ovvero:
            data[1] = 4
            i += 1
        3° ciclo
            viene eseguito l'else, ovvero:
            data[2] = 7
            j += 1
        
PSEUDO-CODICE
merge(A, p, q, r)
    n1 = q-p
    n2 = r-q

    for i from 0 to n1
        L[i] = A[p+i]

    for j from 0 to n2
        R[j] = A[q+j]
    
    i = 0
    j = 0

    for k from 0 to A.length
        if L[i] < R[j]
            A[k] = L[i]
            i += 1
        else
            A[k] = R[j]
            j += 1


merge-sort(A, p, r)
if p < r
    q = r + p / 2
    merge-sort(A, p, q)
    merge-sort(A, q+1, r)
    merge(A, p, q, r)

'''