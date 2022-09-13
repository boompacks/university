def binary_search(data, n):
    if len(data) < 1:
        return 'Elemento non presente'
    
    mid = len(data) // 2
    if data[mid] == n:
        return mid
    elif data[mid] > n:
        binary_search(data[0:mid], n)
    else:
        binary_search(data[mid+1:], n)


def main():
    data = [4, 5, 7, 11]
    print( binary_search(data, 7) )
    print( binary_search(data, 9) )


if __name__ == '__main__':
    main()