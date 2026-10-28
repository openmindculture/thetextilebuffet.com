const bar = document.querySelector('header.wp-block-template-part');
addEventListener('scroll', () => bar.classList.toggle('is-stuck', scrollY > 10), { passive: true });
console.log('initializied sticky');