/*
Scrivere un programma tale per cui quando viene mandato in esecuzione il processo che ne deriva genera un processo figlio
Il processo padre scrive nello standard output il proprio id e il valore di ritorno della chiamata di sistema fork
Il processo figlio scrive nello standard output il proprio id, il valore di ritorno della chiamata di sistema fork e l’id del padre
*/

#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>


int main(){
    pid_t i = 0;

    i = fork();

    if(i == -1) exit(0);

    if(i == 0){
        printf("ID processo figlio: %d \nValore di ritorno di fork(): %d \nID del padre: %d\n", getpid(), i, getppid());
        printf("--------------------------\n");
    } else {
        printf("ID padre: %d \nValore di ritorno di fork(): %d\n", getpid(), i);
        printf("--------------------------\n");
    }
    return 1;
}