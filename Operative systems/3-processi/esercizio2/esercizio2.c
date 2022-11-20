/*
Scrivere un programma che generi un processo figlio.
Il padre dovrà scrivere a video “output del processo padre”
Il figlio dovrà scrivere a video “output del processo figlio”
*/

#include <sys/types.h>
#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>

int main(){
    pid_t i = 0;

    i = fork();

    if(i == -1) exit(0);

    if(i == 0){
        printf("Output del processo figlio\n");
    } else{
        printf("Output del processo padre\n");
    }
    return 1;
}