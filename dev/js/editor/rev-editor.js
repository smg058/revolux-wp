export const message = 'Webpack is working!'

// Basic DOM test
document.addEventListener('DOMContentLoaded', () => {
  const el         = document.createElement('div')
  el.textContent   = message
  el.style.cssText = `
    background: #2b7efe;
    color: white;
    font-family: sans-serif;
    font-weight: 600;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 9999;
  `
  document.body.appendChild(el)
  console.log('%c✅ Webpack compiled and JS loaded successfully.', 'color: lime; font-weight: bold;')
})
