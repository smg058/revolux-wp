export function multiply(a, b) {
  return a * b
}

document.addEventListener('DOMContentLoaded', () => {
  const result = multiply(7, 6)

  const box         = document.createElement('div')
  box.innerHTML     = `7 × 6 = <strong>${result}</strong>`
  box.style.cssText = `
    background: #16a34a;
    color: #fff;
    font-family: monospace;
    padding: 0.75rem 1.25rem;
    border-radius: 6px;
    position: fixed;
    bottom: 1rem;
    right: 1rem;
    z-index: 9999;
  `
  document.body.appendChild(box)
  console.log(`✅ test3.js multiply(7,6) = ${result}`)
})
