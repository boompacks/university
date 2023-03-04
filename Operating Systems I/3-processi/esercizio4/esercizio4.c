/*
Scrivere un programma tale per cui quando mandato in esecuzione il processo che ne deriva genera un processo figlio
Il processo padre scrive nello standard output il proprio id e il valore di ritorno della chiamata di sistema fork e aspetta la terminazione del figlio
Il processo figlio scrive nello standard output il proprio id, il valore di ritorno della chiamata di sistema fork e l’id del padre, aspetta 5 secondi e termina
*/

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>

int main(){
    pid_t i = 0;
    int status;

    i = fork();

    if(i == -1) exit(0);

    if(i == 0){
        printf("Figlio:\n");
        printf("ID: %d, Valore di fork(): %d, ID padre: %d\n", getpid(), i, getppid());
        printf("---------------------\n");
        sleep(5);
    } else{
        printf("Padre:\n");
        printf("ID: %d, Valore di fork(): %d\n", getpid(),  i);
        printf("---------------------\n");
        wait(&status);
    }
    return 1;
}