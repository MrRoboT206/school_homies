<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Homies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Stile per lo sfondo con testo a mattoni */
        .background-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .text-row {
            position: relative;
            height: 70px;
            margin-bottom: 20px;
            display: flex;
            white-space: nowrap;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            width: 200%;
        }
        
        .text-row:nth-child(odd) {
            animation-name: scrollLeft;
            animation-duration: 60s;
        }
        
        .text-row:nth-child(even) {
            animation-name: scrollRight;
            animation-duration: 80s;
        }
        
        .brick {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 10px 30px;
            margin: 0 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            color: rgba(255, 255, 255, 0.3);
            font-weight: 600;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px; /* Migliora la spaziatura tra le lettere */
        }
        
        /* Le righe dispari si muovono in diverse velocità per varietà */
        .text-row:nth-child(1) { animation-duration: 60s; }
        .text-row:nth-child(3) { animation-duration: 75s; }
        .text-row:nth-child(5) { animation-duration: 65s; }
        .text-row:nth-child(7) { animation-duration: 70s; }
        .text-row:nth-child(9) { animation-duration: 80s; }
        
        /* Le righe pari si muovono in diverse velocità per varietà */
        .text-row:nth-child(2) { animation-duration: 80s; }
        .text-row:nth-child(4) { animation-duration: 65s; }
        .text-row:nth-child(6) { animation-duration: 70s; }
        .text-row:nth-child(8) { animation-duration: 75s; }
        .text-row:nth-child(10) { animation-duration: 60s; }
        
        @keyframes scrollLeft {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        @keyframes scrollRight {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }
        
        /* Stile container login */
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 360px;
            max-width: 90%;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .welcome-text {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
            text-align: center;
        }
        
        .subtext {
            font-size: 14px;
            color: #777;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 12px;
            color: #555;
            margin-bottom: 6px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: #6a11cb;
            outline: none;
        }
        
        .login-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: opacity 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-button:hover {
            opacity: 0.9;
        }
        
        .arrow-icon {
            margin-left: 8px;
        }
        
        .register-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        
        .register-link {
            color: #6a11cb;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Sfondo con testo a mattoni -->
    <div class="background-text" id="background-text">
        <!-- I contenuti delle righe saranno generati dinamicamente tramite JavaScript -->
    </div>

    <div class="login-container">
        <div class="welcome-text">Welcome,</div>
        <div class="subtext">sign up to continue</div>
        
        <form action="../priv/gestioneUtenti/loginUser.php" method="POST">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="login-button">
                Let's go <span class="arrow-icon">→</span>
            </button>
        </form>

        <div class="register-text">
            Non hai un account? <a href="registrazione.php" class="register-link">Registrati</a>
        </div>
    </div>

    <script>
        // Funzione per generare dinamicamente le righe di sfondo
        function generateBackgroundRows() {
            const backgroundText = document.getElementById('background-text');
            const windowHeight = window.innerHeight;
            const rowHeight = 90;
            const rowsNeeded = Math.ceil(windowHeight / rowHeight) + 1;
            
            backgroundText.innerHTML = '';
            
            for (let i = 0; i < rowsNeeded; i++) {
                const row = document.createElement('div');
                row.className = 'text-row';
                
                const duration = i % 2 === 0 ? 
                    65 + (i * 2) % 15 : 
                    75 + (i * 3) % 15;
                
                row.style.animationDuration = `${duration}s`;
                
                const screenWidth = window.innerWidth;
                const brickWidth = 300;
                const bricksNeeded = Math.ceil((screenWidth * 2) / brickWidth) + 2;
                
                for (let j = 0; j < bricksNeeded; j++) {
                    const brick = document.createElement('span');
                    brick.className = 'brick';
                    brick.textContent = 'SCHOOL HOMIES';
                    
                    const opacity = 0.2 + (Math.random() * 0.2);
                    brick.style.color = `rgba(255, 255, 255, ${opacity})`;
                    
                    const bgOpacity = 0.05 + (Math.random() * 0.15);
                    brick.style.backgroundColor = `rgba(255, 255, 255, ${bgOpacity})`;
                    
                    row.appendChild(brick);
                }
                
                backgroundText.appendChild(row);
            }
        }
        
        window.addEventListener('load', generateBackgroundRows);
        window.addEventListener('resize', generateBackgroundRows);
    </script>
</body>
</html>