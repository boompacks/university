#include <stdio.h>
#include <pthread.h>

typedef struct{
    int lunghezza;
    char carattere;
} argomenti;


void* print_xs(void *args){
    argomenti *dati = (argomenti*)(args);

    for(int j=0; j < dati->lunghezza; j++){
        printf("%c", dati->carattere);
    }

    pthread_exit(NULL);
}


int main(){
    pthread_t thread;
    argomenti arg1, arg2;

    printf("Inserire il carattere da stampare nel 1° thread: ");
    fflush(stdin);
    scanf("%c", &arg1.carattere);

    printf("Inserire la lunghezza da usare nel 1° thread: ");
    fflush(stdin);
    scanf("%d", &arg1.lunghezza);

    printf("Inserire il carattere da stampare nel 2° thread: ");
    fflush(stdin);
    scanf("%c", &arg2.carattere);

    printf("Inserire la lunghezza da usare nel 2° thread: ");
    fflush(stdin);
    scanf("%d", &arg2.lunghezza);

    pthread_create(&thread, NULL, &print_xs, (void *)(&arg2));
    pthread_join(thread, NULL);

    for(int i=0; i < arg1.lunghezza; i++){
        printf("%c", arg1.carattere);
    }

    return 1;
}
