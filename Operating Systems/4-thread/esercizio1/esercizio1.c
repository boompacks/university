#include <stdio.h>
#include <pthread.h>

void* print_xs(void *unused){
    while(1){
        printf("x");
    }

    return NULL;
}


int main(){
    pthread_t thread;
    pthread_create(&thread, NULL, &print_xs, NULL);

    while(1){
        printf("o");
    }
    return 1;
}