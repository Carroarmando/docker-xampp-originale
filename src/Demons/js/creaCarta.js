function creaCarta(classNames, imgSrc, onClickCallback, tooltipText = "") {
    const container = document.createElement('div');
    container.classList.add('card-tooltip-container');

    const div = document.createElement('div');
    classNames.split(' ').forEach(c => div.classList.add(c));

    // Creo l'immagine e la inserisco dentro la card
    const img = document.createElement('img');
    img.src = imgSrc;
    img.alt = tooltipText || "Carta";
    
    div.appendChild(img);

    if (typeof onClickCallback === 'function')
        div.addEventListener('click', () => onClickCallback(imgSrc));

    if (tooltipText)
        container.title = tooltipText;

    container.appendChild(div);
    return container;
}