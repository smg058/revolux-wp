const now = new Date().toLocaleTimeString()

console.log(`🕒 Webpack test2.js loaded at ${now}`)

// Create a small floating label
document.addEventListener('DOMContentLoaded', () => {
  const tag         = document.createElement('div')
  tag.textContent   = `test2.js loaded at ${now}`
  tag.style.cssText = `
    background: #ff6b6b;
    color: #fff;
    font-family: sans-serif;
    font-weight: bold;
    padding: 0.75rem 1rem;
    border-radius: 6px;
    position: fixed;
    bottom: 1rem;
    left: 1rem;
    z-index: 9999;
  `
  document.body.appendChild(tag)
})
