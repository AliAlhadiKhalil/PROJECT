package snakeGame;

import java.awt.*;

import java.awt.event.*;

import java.util.Random;

import javax.swing.*;

public  class GamePanel extends JPanel implements ActionListener{
	
	static final int screenHeight=600;
	static final int screenWidth=600;
	static final int unitSize= 25;
	static final int gameUnit= (screenHeight*screenWidth)/unitSize;
	static final int delay= 100;
	
	final int x[]=new int[gameUnit];
	final int y[]=new int[gameUnit];

	int applesEaten;
	int snakeBodyParts=6;
	int appleX;
	int appleY;
	int score=0;
	char direction='R';
	boolean running=false;
	Timer timer;
	Random random;
	
	GamePanel() {
		random=new Random();
		this.setPreferredSize(new Dimension(screenWidth,screenHeight));
		this.setBackground(Color.black);
		this.setFocusable(true);
		this.addKeyListener(new MyKeyAdapter());
		startGame();
	}
	
	 
	public void startGame() {
        newApple();
        running = true;
		 timer = new Timer( delay , this); // Ensure 'timer' is declared elsewhere
		 timer.start();
		 
		
    }
	
	
	public void paintComponent(Graphics g) {
		super.paintComponent(g);
		draw(g); 
		g.setColor(Color.red);
	    g.setFont(new Font("Ink Free", Font.BOLD, 30));
	    g.drawString("Score: " + score, 10, 30);
	}
	
	
	
	public void draw(Graphics g) {
		if(running==true) {
			/*
			 * for(int i =0;i<screenHeight/unitSize ;i++) { g.drawLine(i*unitSize, 0,
			 * i*unitSize, screenHeight); g.drawLine(0,i*unitSize, screenWidth, i*unitSize
			 * ); }
			 */
			g.setColor(Color.red);
			g.fillOval(appleX, appleY,unitSize, unitSize);
			
			for(int i=0;i<snakeBodyParts;i++) {
				if(i==0) {
					g.setColor(Color.green);
					g.fillRect(x[i], y[i], unitSize, unitSize);
				}
				else {
					g.setColor(new Color(45,100,0));
					g.fillRect(x[i], y[i], unitSize, unitSize);
				}	
			}
		}
		else {
			gameOver(g);
		}
	}
	
	
	public void newApple() {
		appleX= random.nextInt(screenWidth/unitSize)*unitSize;
		appleY= random.nextInt(screenHeight/unitSize)*unitSize;

	}
	
	
	public void move() {
		for(int i=snakeBodyParts;i>0;i--) {
			x[i]=x[i-1];
			y[i]=y[i-1];
		}
		
		switch(direction) {
		case'U':
			 y[0]=y[0]-unitSize;
			 break;
		case'D':
			y[0]=y[0]+unitSize;
			 break;
		case'R':
			x[0]=x[0]+unitSize;
			 break;
		case'L':
			x[0]=x[0]-unitSize;
			 break;
		}
	}
	
	
	public void checkApple() {//checking if snake eats the apple
		if (x[0] == appleX && y[0] == appleY) {
	        snakeBodyParts++;
	        applesEaten++;
	        score++; 
	        newApple();
	    }
	}
	
	public void checkCollisions() {
		//checking if head of the snake collides with body 
		for(int i=snakeBodyParts;i>0;i--) {
			if (x[0] == x[i] && y[0]==y[i]) {
				running=false;
			}
		}
		
		//check if head touches left border
		if(x[0]<0) {
			running=false;
		}
		//check if head touches right border
		if(x[0]>screenWidth) {
			running=false;
		}
		//check if head touches bottom border
		if(y[0]<0) {
			running=false;
		}
		//check if head touches left border
		if(y[0]>screenHeight) {
			running=false;
		}
		
		if(running==false) {
			timer.stop();
		}
	}
	
	
	public void gameOver(Graphics g) {
		String gameOverMsg = "Game Over";
	    Font gameOverFont = new Font("SansSerif", Font.BOLD, 48);
	    g.setFont(gameOverFont);
	    g.setColor(Color.RED);
	    FontMetrics fontMetrics = getFontMetrics(gameOverFont);
	    int x = (screenWidth - fontMetrics.stringWidth(gameOverMsg)) / 2;
	    int y = screenHeight / 2;
	    g.drawString(gameOverMsg, x, y);
	}

	


	@Override
	public void actionPerformed(ActionEvent e) {
		// TODO Auto-generated method stub
		  if (running==true) {
	            // Update game state
	            move();
	            checkApple();
	            checkCollisions();
	            // Repaint the panel to update graphics
	        }repaint(); 
	}
	
	public class MyKeyAdapter extends KeyAdapter{

		@Override
		public void keyPressed(KeyEvent e) {
			// TODO Auto-generated method stub
			int key = e.getKeyCode();
	        switch (key) {
	            case KeyEvent.VK_LEFT:
	                if(direction != 'R') {
	                	direction = 'L';
	                }
	                break;
	            case KeyEvent.VK_RIGHT:
	            	if(direction != 'L') {
	                direction = 'R';
	            	}
	                break;
	            case KeyEvent.VK_UP:
	            	if(direction != 'D') {
	                direction = 'U';
	            	}
	                break;
	            case KeyEvent.VK_DOWN:
	            	if(direction != 'U') {
	                direction = 'D';
	            	}
	                break;
	        }
			
		}
		 
	}
	
}
