document.addEventListener('DOMContentLoaded', async () => {
  const msg         = document.createElement('div')
  msg.textContent   = 'Loading dynamic import...'
  msg.style.cssText = `
    background: #6366f1;
    color: white;
    font-family: sans-serif;
    padding: 1rem;
    border-radius: 8px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
  `
  document.body.appendChild(msg)

  const { default: data } = await import('./test-data.js')
  msg.textContent         = `Dynamic import successful: ${data}`
  console.log(`📦 test4.js dynamic import result: ${data}`)
})
