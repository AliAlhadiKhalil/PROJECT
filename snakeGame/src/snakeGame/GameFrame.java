package snakeGame;

import javax.swing.JFrame;

public class GameFrame  extends JFrame {
	
	GameFrame(){
		this.add(new GamePanel());
		this.setTitle("Snake");
		this.setSize(800, 600); // Set dimensions as needed
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE); // Close operation
        this.setVisible(true); // Make the frame visible
        this.pack();
        this.setLocationRelativeTo(null);
        this.setResizable(false);
	}
}
