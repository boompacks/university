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
    FILE *file;
    int counter;
    char c;
    if((file = fopen("results.numc", "a")) == NULL ){
            printf("The file does not exist\n");
            exit(1);
        }
        else{
           while((c = fgetc(data.f)) != EOF){
                if(c != ' ')
                    counter++;
        }
    }
    
    fprintf(file, "There are %d characters inside the file '%s'\n", counter, data.filename);
    fclose(file);
    fclose(data.f);
    pthread_exit(NULL);
}


int main(){
    pthread_t thread_id;
    args parameters;

    printf("Insert below the names of the files you want to open (type 'exit' to stop): \n");
    
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
            pthread_join(thread_id, NULL);
        }
    }
    return 1;   
}