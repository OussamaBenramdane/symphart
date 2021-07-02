const articles = document.getElementById('articles');
 console.log(articles) ;
if(articles){
    articles.addEventListener('click',(e)=>{
        if(e.target.className ==='btn btn-danger delete-article btn-sm'){
            alert(2);
        }
    });
}