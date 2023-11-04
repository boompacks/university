import random
from tkinter import *
from PIL import ImageTk, Image

class Board:
    offsetX = 12
    offsetY = 14
    step = 64
    queenPos = [None] * 8

    def __init__(self):
        self.board = Image.open("chessboard.png")
        self.board = self.board.resize((512, 512), Image.Resampling.LANCZOS)
        self.queen = Image.open("queen.png")
    
    def setPos(self, state):
        for i in range(8):
            self.queenPos[i] = state[i]

    def redraw(self, root):
        self.root = root
        self.drawImage = self.board.copy()
        for i in range(8):
            if (self.queenPos[i] != -1):
                self.drawImage.paste(self.queen, (self.offsetX + i*self.step, self.offsetY + self.queenPos[i]*self.step), self.queen)
        self.drawImage = ImageTk.PhotoImage(self.drawImage)
        self.boardLabel = Label(self.root,image=self.drawImage)
        self.boardLabel.place(x=4, y=4)
        return 
