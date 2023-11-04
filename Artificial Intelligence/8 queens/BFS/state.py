class State:

    def __init__(self):
        self.current_state = [-1] * 8
        self.frontier = []
        self.explored_set = set()

    def evaluate_threats(self, max_column):
        threats = 0
        for i1 in range(max_column):
            for i2 in range(i1+1, max_column):
                if (self.current_state[i1] == self.current_state[i2] or abs(i1 - i2) == abs(self.current_state[i1] - self.current_state[i2])):
                    threats += 1
        return threats

    def goal_state(self):
        if self.evaluate_threats(8 - self.current_state.count(-1)) > 0 or (-1 in self.current_state):
            return False
        return True
    
    def generate_states(self):
        next_states = []
        if -1 in self.current_state:
            available_columns = [i for i in range(8) if i not in self.current_state]
            column = self.current_state.index(-1)
            for i in available_columns:
                next_state = self.current_state.copy()
                next_state[column] = i
                if (tuple(next_state) not in self.explored_set):
                    next_states.append(next_state)
        return next_states
    
    def bfs(self):
        self.explored_set.add(tuple(self.current_state.copy()))
        if self.evaluate_threats(8 - self.current_state.count(-1)) == 0:
            self.frontier.extend(self.generate_states())
        self.current_state = self.frontier.pop(0)

        if not self.frontier:
            return False
    




