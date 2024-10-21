document.getElementById('loadingModal').style.display = 'flex'

window.addEventListener('load', () => {
    document.getElementById('loadingModal').style.display = 'none'
})

window.addEventListener('beforeunload', () => {
    document.getElementById('loadingModal').style.display = 'flex'
})