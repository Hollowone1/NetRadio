function myFunction() {
    const burgerIcon = document.querySelector('.icon i');
    const myLinks = document.getElementById('myLinks');

  
    if (myLinks.style.display === 'block') {
    
      burgerIcon.classList.add('gg-menu');
      myLinks.style.display = 'none';
    } else {
      myLinks.style.display = 'block';
      burgerIcon.classList.add('gg-close');
    }

  }
  


  
  