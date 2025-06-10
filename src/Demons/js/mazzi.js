candles = [1, 2, 3, 4, 5];

neighborhood = [
1, 1, 1, 1, 1, 1, 
2, 
3, 3, 3, 3, 3, 3, 
4, 4, 
5, 
6, 6, 
7, 7, 
8, 8, 
9, 9, 
10, 10, 
11, 11, 11, 11, 
12, 12, 
13, 13, 
14, 14, 14, 14, 
15, 15, 
16, 16, 
17, 17, 17, 17, 17, 17, 
18, 
19, 19, 19, 19, 19, 19, 
20, 20, 
21, 21, 21, 21, 
22, 22, 
23, 23, 
24, 24, 
25, 25, 25, 25, 
26, 26, 
27, 27, 27, 27, 
28, 28, 
29, 29, 
30, 30, 
31, 31, 
32, 32, 
33, 33, 
34, 34, 
35, 35, 
36, 
37, 37, 
38, 38];

demons = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ,16, 17, 18, 19, 20];

scarti = [];

async function get_neighborhood_offset() 
{
    // Prima fetch (aspetta correttamente)
    const game_res = await fetch(`../php/api/get/game.php?game_id=${game_id}`);
    const game = await game_res.json();
    return game.neighborhood_offset;
}

async function set_neighborhood_offset(o = 0)
{
    // Seconda fetch (aspetta anche questa)
    const offset_res = await fetch(`../php/api/update/neighborhood_offset.php?game_id=${game_id}&offset=${o}`);
    await offset_res.text(); // o json(), se serve la risposta
}

async function get_neighbor(n = 1, o = 0)
{
    const offset = get_neighborhood_offset() + o;
    return neighborhood.slice(offset, offset + n);
}

async function get_demons_offset() 
{
    // Prima fetch (aspetta correttamente)
    const game_res = await fetch(`../php/api/get/game.php?game_id=${game_id}`);
    const game = await game_res.json();
    return game.demons_offset;
}

async function set_demons_offset(o = 0)
{
    // Seconda fetch (aspetta anche questa)
    const offset_res = await fetch(`../php/api/update/demons_offset.php?game_id=${game_id}&offset=${o}`);
    await offset_res.text(); // o json(), se serve la risposta
}

async function get_demon(n = 1, o = 0) 
{
    const offset = get_demons_offset() + o;
    return demons.slice(offset, offset + n);
}