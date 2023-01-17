#include <stdio.h>
#include <stdlib.h> 
#include <pthread.h>
#include <string.h>

typedef struct{
    FILE *f;
    char filename[50];
} args;


void* read_chars(void* arguments){
    args data = *(args*)(arguments);
    int *res = malloc(sizeof(int));
    int counter = 0;
    char c;

    while((c = fgetc(data.f)) != EOF){
        if(c != ' ')
            counter++;
    }

    *res = counter;
    pthread_exit((void*)(res));
}


int main(){
    pthread_t thread_id;
    args parameters;
    void *returned_data;

    printf("Insert the names of the files you want to open (type 'exit' to stop): \n");

    while(1){
        fgets(parameters.filename, sizeof(parameters.filename), stdin);
        parameters.filename[strcspn(parameters.filename, "\n")] = '\0';

        if(strcmp(parameters.filename, "exit" ) == 0){
            printf("Process terminated successfully!\n");
            exit(1);
        } 
            

        if((parameters.f = fopen(parameters.filename, "r")) == NULL ){
            printf("The file does not exist\n");
            exit(1);
        }
        else{
            pthread_create(&thread_id, NULL, &read_chars, (void*)(&parameters));
            pthread_join(thread_id, &returned_data);
            fclose(parameters.f);
        }

        printf("There are %d characters inside the file named: '%s'\n", *(int*)(returned_data), parameters.filename);
    }
    free(returned_data);
    return 1;   
}