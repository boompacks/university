#include <stdio.h>
#include <pthread.h>
#include <stdlib.h>
#include <string.h>
// #include <semaphore.h>

#define DIM 6
#define BUFF_EMPTY 2
#define BUFF_FULL 1
#define BUFF_OK 0

typedef struct{
	int first; // Punto prelievo
	int last;  // Punto di inserimento
	unsigned int num; /* Number of items in the buffer */
	int dim;
	int *p_array;
	pthread_mutex_t m;
} t_buffer;

t_buffer* buffer_init(int dim);
int buffer_put(t_buffer *b, int value);
int buffer_get(t_buffer *b, int *value);

t_buffer *buffer;

void *th_get(void *p) {
    int val, ret;
    
    /* read a value from the buffer */
    ret = buffer_get( buffer, &val );
    if (ret == BUFF_EMPTY)
    	printf("EMPTY -->\n");
    else
    	printf( "%d -->\n", val);
}

void *th_put(void *p) {
    int val, ret;
    
    /* write a value into the buffer */
    val =rand(); // % 100 + 1;
    ret = buffer_put( buffer, val );
    if (ret == BUFF_FULL)
    	printf( "--> FULL\n");
    else
    	printf( "--> %d\n", val);
}

int main(int argc, const char *argv[]){
    pthread_t threadr[80];
    pthread_t threadw[80];
    time_t t;
    
    srand((unsigned) time(&t));
    
    buffer = buffer_init(DIM);
    if(buffer == NULL)
        fprintf(stderr, "Errore al. mem");
    
	for(int i=0;i<80;++i) {
        pthread_create(&threadr[i], NULL, th_get, NULL);
    }
    for(int i=0;i<80;++i) {
        pthread_create(&threadw[i], NULL, th_put, NULL);
    }
    for(int i=0;i<10;++i){
        pthread_join(threadr[i], NULL);
        pthread_join(threadw[i], NULL);
    }
    
    /*  Do some work */

    return 0;
}


t_buffer* buffer_init(int dim){

    int *p_array = calloc(dim, sizeof(int)); 
    if(p_array == NULL)
        return NULL;

    t_buffer* buff = malloc(sizeof(t_buffer));
    if(buff == NULL)
        return NULL;
    buff->dim = dim;
    buff->first = 0;
    buff->last = 0;
    buff->num = 0;
    buff->p_array = p_array;

    pthread_mutex_init( &(buff->m), NULL);
    
    return buff;
}

int  buffer_put(t_buffer *bu, int value){

    pthread_mutex_lock(&(bu->m));  /* Critical section starts here */
    
    if (bu->num < bu->dim){
        (bu->last)++;
        bu->last = ((bu->last)%(bu->dim));
        bu->p_array[bu->last] = value;
        (bu->num)++;
        pthread_mutex_unlock(&(bu->m));     /* Critical section ends here ... */
        return BUFF_OK;
    } else{
    	pthread_mutex_unlock(&(bu->m));     /*  ... or here */
	return BUFF_FULL;
	}
}

int buffer_get(t_buffer *bu, int *rvalue){

    pthread_mutex_lock(&(bu->m)); /* Critical section starts here */
    
    if (bu->num > 0) {         /* not empty buffer */
    	*rvalue = bu->p_array[bu->first];
    	bu->p_array[bu->first] = 0;
    	(bu->first)++;
    	bu->first = ((bu->first)%(bu->dim));
    	(bu->num)--;
    	pthread_mutex_unlock(&(bu->m)); /* Critical section ends here ... */
    	return BUFF_OK;
    } else {
    	pthread_mutex_unlock(&(bu->m)); /* ... or here */
    	return BUFF_EMPTY;
    	}
}


