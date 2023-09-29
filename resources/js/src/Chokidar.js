let chokidar = function() {
    let guard = localStorage.getItem('guard');
    let token = localStorage.getItem('token');
    if(token){
        return guard;
    }
    return "Error";
};

export default chokidar;