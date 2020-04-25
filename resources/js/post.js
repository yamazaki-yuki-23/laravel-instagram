window.addEventListener('DOMContentLoaded', function() {
    document.getElementById('submit1').disabled = true;
    document.getElementById('input1').addEventListener('keyup', function() {
        if(this.value.length >= 1) {
            document.getElementById('submit1').disabled = false;
        }else{
            document.getElementById('submit1').disabled = true;
        }
    })
})
