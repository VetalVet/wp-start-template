// массив истории поиска
let search = [];

// То что ввели в поиск
let newItem = 'test14';

// Если последние 5 запросов есть
if(search.length == 5){
    localStorage.setItem('paydosearch1', localStorage.getItem('paydosearch2'));
    localStorage.setItem('paydosearch2', localStorage.getItem('paydosearch3'));
    localStorage.setItem('paydosearch3', localStorage.getItem('paydosearch4'));
    localStorage.setItem('paydosearch4', localStorage.getItem('paydosearch5'));

    localStorage.setItem('paydosearch5', newItem);

    for(let i=0; i<localStorage.length; i++) {
        if(localStorage.getItem('paydosearch' + i)){
            // console.log('paydosearch' + i + ': ' + localStorage.getItem(i))
            search.push(localStorage.getItem('paydosearch' + i))
        }
    }
    
    console.log(search.reverse());
    
    // Показать выпадающий список запросов
    search.forEach(item => {
        console.log(item);
    })
} 
// Если запросов меньше 5
else if(search.length < 5){ 
    for(let i=1; i<6; i++) {
        // if(localStorage.getItem('paydosearch' + i)){
            localStorage.setItem('paydosearch' + i, newItem);
            // console.log('paydosearch' + i + ': ' + localStorage.getItem(i))
            search.push(localStorage.getItem('paydosearch' + i))
        // }
    }

    console.log(search.reverse());
    
    // Показать выпадающий список запросов
    search.forEach(item => {
        console.log(item);
    })
}