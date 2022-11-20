/* Fare in modo che il padre di un processo figlio diventi init */

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>

int main(){
    pid_t i = 0;

    i = fork();

    if(i == -1) exit(0);

    if(i == 0){
        printf("ID del nuovo padre: %d\n", getppid());
    } else{
        printf("ID del padre iniziale: %d\n", getpid());
        exit(0);
    }

    return 1;
}