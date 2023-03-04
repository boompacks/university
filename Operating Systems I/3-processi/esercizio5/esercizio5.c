/* Scrivere un programma che crei un processo zombie */

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>

int main(){
    pid_t i = 0;

    i = fork();

    if(i == -1) exit(0);

    if(i == 0){
        printf("Non essendoci wait() nel padre, dovrebbe crearsi un processo zombie\n");
        exit(0);
    } else{
        printf("Output del processo padre\n");
    }

    return 1;
}