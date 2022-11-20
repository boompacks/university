/* Stampare l'ID del programma e quello del processo padre */

#include <sys/types.h>
#include <unistd.h>
#include <stdio.h>

int main(){
    printf("Father ID: %d \nSon ID: %d\n", getpid(), getppid());
}