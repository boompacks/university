from board import *
from state import *

def exitCB():
    global running, exiting
    running = False
    exiting = True
    
def startAlgo():
    global running, exiting
    running = True

    s = State()
    while running and not exiting:
        stateText.set(f"Current state: {s.current_state}")
        s.bfs()
        board.setPos(s.current_state)
        board.redraw(root)
        root.update_idletasks()
        root.update()
        if s.goal_state():
            running = False
        
running = False
exiting = False

root = Tk()
root.title("PyIterative")
root.minsize(524, 820)
root.maxsize(524, 820)

exitButton = Button(root, text="Exit", command = exitCB, font=("Arial", 25))
exitButton.place(x = 160, y = 750)

startButton = Button(root, text="Start", command = startAlgo, font=("Arial", 25))
startButton.place(x = 270, y = 750)

stateText = StringVar()
stateLabel = Label( root, textvariable=stateText, font=("Arial", 25))
stateLabel.place(x = 50, y = 532)

board = Board()

while not exiting:
    root.update_idletasks()
    root.update()

root.destroy