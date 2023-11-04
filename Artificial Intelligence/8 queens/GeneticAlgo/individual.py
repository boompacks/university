import random

class Individual:

    def __init__(self, dna1 = None, dna2 = None):
        self.dna = [None] * 8
        self.fitness = 0.
        if dna1 != None and dna2 != None:
            cross = random.randint(0,7)
            self.dna = dna1[:cross] + dna2[cross:]
        elif dna1 != None:
            self.dna = dna1.copy()
        else:    
            self.randomize()

    def randomize(self):
        for i in range(8):
            self.dna[i] = random.randint(0,7)

    def evaluate(self):
        threats = 0
        for i1 in range(7):
            for i2 in range(i1+1, 8):
                if self.dna[i1] == self.dna[i2]:
                    threats += 1
                elif abs(i1 - i2) == abs(self.dna[i1] - self.dna[i2]):
                    threats += 1
        self.fitness = (28 - threats) / 28


