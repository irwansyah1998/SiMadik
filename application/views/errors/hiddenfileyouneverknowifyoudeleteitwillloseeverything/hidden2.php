<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>I Am Wacthing You!!!</title>
  <style>
    /* CSS Styles */
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #0a0a0a;
      color: #fff;
    }

    .container {
      width: 50%;
      margin: 50px auto;
      background-color: rgba(0, 0, 0, 0.5);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      position: relative;
      z-index: 1;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    input[type="text"],
    input[type="email"],
    textarea,
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: none;
      border-radius: 5px;
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
      outline: none;
      resize: none;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      background-color: #3498db;
      color: #fff;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #2980b9;
    }

    canvas {
      position: absolute;
      top: 0;
      left: 0;
    }

    /* Efek teks bersinar dan berkilau */
    .text-glow {
      font-size: 3em;
      font-weight: bold;
      text-align: center;
      color: #fff;
      text-shadow: 0 0 10px #fff, 0 0 20px #00f, 0 0 30px #00f, 0 0 40px #00f, 0 0 50px #00f, 0 0 60px #00f, 0 0 70px #00f;
      animation: glowing 2s linear infinite;
    }

    @keyframes glowing {
      0% {
        text-shadow: 0 0 10px #fff, 0 0 20px #00f, 0 0 30px #00f, 0 0 40px #00f, 0 0 50px #00f, 0 0 60px #00f, 0 0 70px #00f;
      }
      100% {
        text-shadow: 0 0 20px #fff, 0 0 30px #00f, 0 0 40px #00f, 0 0 50px #00f, 0 0 60px #00f, 0 0 70px #00f, 0 0 80px #00f;
      }
    }

    /* Efek animasi untuk judul */
    .title-animation {
      animation: titleGlow 2s linear infinite;
      display: inline-block;
      font-size: 2em;
    }

    /* Style untuk elemen yang akan di-render secara besar-besaran */
    .star {
      position: absolute;
      width: 0;
      height: 0;
      border-left: 20px solid transparent;
      border-right: 20px solid transparent;
      border-bottom: 35px solid blue;
      transform: rotate(35deg);
      filter: brightness(200%);
      animation: glowing 2s infinite alternate;
    }

    @keyframes glowing {
      from {
        filter: brightness(200%);
      }
      to {
        filter: brightness(400%);
      }
    }
  </style>
</head>
<body>
  <canvas id="myCanvas"></canvas>

  <div class="container">
    <?php
    if ($this->input->post('Name')!==null) {
      // $this->encryption->encrypt($plain_text);
      // $this->encryption->decrypt($encrypted_text);
  ?>
    <h2 class="text-glow">Your Name is</h2><br>
    <textarea readonly><?= $this->encryption->decrypt($this->input->post('Name')) ?></textarea>
  <?php
    }else{
  ?>
    <h2 class="text-glow">Hello there<br>Don't Afraid of Dark!<br>Who am I?<br>I am The Darksider!<br>Who Are You?</h2>
  <?php } ?>
    <form action="" method="POST">
      <input type="text" name="Name" placeholder="Your Name">
      <input type="submit" value="Submit">
    </form>
    
  </div>
  

<script>
  const canvas = document.getElementById('myCanvas');
  const ctx = canvas.getContext('2d');

  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  function randomColor() {
    return `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 0.8)`;
  }

  const circles = [];
  const numCircles = 50;

  for (let i = 0; i < numCircles; i++) {
    circles.push({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      radius: Math.random() * 30 + 10,
      speedX: Math.random() - 0.5,
      speedY: Math.random() - 0.5,
      color: randomColor(),
      growth: Math.random() * 0.5 + 0.2, // Menambahkan faktor pertumbuhan
    });
  }

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < numCircles; i++) {
      const circle = circles[i];

      ctx.beginPath();
      const gradient = ctx.createRadialGradient(circle.x, circle.y, 0, circle.x, circle.y, circle.radius);
      gradient.addColorStop(0, 'rgba(255, 255, 255, 0.8)');
      gradient.addColorStop(1, 'transparent');
      ctx.arc(circle.x, circle.y, circle.radius, 0, Math.PI * 2);
      ctx.fillStyle = gradient;
      ctx.fill();

      circle.radius += circle.growth; // Memperbesar lingkaran

      // Memantulkan lingkaran saat mencapai ukuran maksimum atau minimum
      if (circle.radius >= 40 || circle.radius <= 10) {
        circle.growth = -circle.growth;
        circle.color = randomColor(); // Mengubah warna saat memantul
      }

      circle.x += circle.speedX;
      circle.y += circle.speedY;

      if (circle.x - circle.radius > canvas.width) {
        circle.x = -circle.radius;
      } else if (circle.x + circle.radius < 0) {
        circle.x = canvas.width + circle.radius;
      }

      if (circle.y - circle.radius > canvas.height) {
        circle.y = -circle.radius;
      } else if (circle.y + circle.radius < 0) {
        circle.y = canvas.height + circle.radius;
      }
    }

    requestAnimationFrame(draw);
  }

  draw();

  const title = document.querySelector('title');
    let count = 0;
    const texts = [
      'Finally you found me!',
      'Who Am I?',
      'I Have Been Here!!!',
      'This is Amazing!',
      'Welcome to My World',
      'The World Will Be End!',
      'This is the end!',
      'Don\'t worry i want to let you suffer!',
      'I am here!',
      'You are not alone!',
      'Belive me!',
      'Maybe i have died!',
      'But You still alive!',
      'Me too!',
      'I live in this!',
      'I am a system!',
      'I am Irwansyah!',
      'Finally you found me!',
      'Who Am I?',
      'I Have Been Here!!!',
      'This is Amazing!',
      'Welcome to My World',
      'The World Will Be End!',
      'This is the end!',
      'Don\'t worry i want to let you suffer!',
      'I am here!',
      'You are not alone!',
      'Belive me!',
      'Maybe i have died!',
      'But You still alive!',
      'Me too!',
      'I live in this!',
      'I am a system!',
      'I am Irwansyah!',
      'Finally you found me!',
      'Who Am I?',
      'I Have Been Here!!!',
      'This is Amazing!',
      'Welcome to My World',
      'The World Will Be End!',
      'This is the end!',
      'Don\'t worry i want to let you suffer!',
      'I am here!',
      'You are not alone!',
      'Belive me!',
      'Maybe i have died!',
      'But You still alive!',
      'Me too!',
      'I live in this!',
      'I am a system!',
      'I am Irwansyah!',
      'Finally you found me!',
      'Who Am I?',
      'I Have Been Here!!!',
      'This is Amazing!',
      'Welcome to My World',
      'The World Will Be End!',
      'This is the end!',
      'Don\'t worry i want to let you suffer!',
      'I am here!',
      'You are not alone!',
      'Belive me!',
      'Maybe i have died!',
      'But You still alive!',
      'Me too!',
      'I live in this!',
      'I am a system!',
      'I am Irwansyah!',
      'Finally you found me!',
      'Who Am I?',
      'I Have Been Here!!!',
      'This is Amazing!',
      'Welcome to My World',
      'The World Will Be End!',
      'This is the end!',
      'Don\'t worry i want to let you suffer!',
      'I am here!',
      'You are not alone!',
      'Belive me!',
      'Maybe i have died!',
      'But You still alive!',
      'Me too!',
      'I live in this!',
      'I am a system!',
      'I am Irwansyah!',
      'Finally you found me!',
      'Who Am I?',
      'I Have Been Here!!!',
      'This is Amazing!',
      'Welcome to My World',
      'The World Will Be End!',
      'This is the end!',
      'Don\'t worry i want to let you suffer!',
      'I am here!',
      'You are not alone!',
      'Belive me!',
      'Maybe i have died!',
      'But You still alive!',
      'Me too!',
      'I live in this!',
      'I am a system!',
      'I am Irwansyah!',
      'Finally you found me!',
      'Who Am I?',
      'I Have Been Here!!!',
      'This is Amazing!',
      'Welcome to My World',
      'The World Will Be End!',
      'This is the end!',
      'Don\'t worry i want to let you suffer!',
      'I am here!',
      'You are not alone!',
      'Belive me!',
      'Maybe i have died!',
      'But You still alive!',
      'Me too!',
      'I live in this!',
      'I am a system!',
      'I am Irwansyah!',
      'Finally you found me!',
      'Who Am I?',
      'I Have Been Here!!!',
      'This is Amazing!',
      'Welcome to My World',
      'The World Will Be End!',
      'This is the end!',
      'Don\'t worry i want to let you suffer!',
      'I am here!',
      'You are not alone!',
      'Belive me!',
      'Maybe i have died!',
      'But You still alive!',
      'Me too!',
      'I live in this!',
      'I am a system!',
      'I am Irwansyah!',
      'Finally you found me!',
      'Who Am I?',
      'I Have Been Here!!!',
      'This is Amazing!',
      'Welcome to My World',
      'The World Will Be End!',
      'This is the end!',
      'Don\'t worry i want to let you suffer!',
      'I am here!',
      'You are not alone!',
      'Belive me!',
      'Maybe i have died!',
      'But You still alive!',
      'Me too!',
      'I live in this!',
      'I am a system!',
      'I am Irwansyah!'
      // Tambahkan teks baru di sini
    ];
    
    setInterval(() => {
      title.innerText = texts[count % texts.length];
      count++;
    }, 500);
</script>

</body>
</html>
