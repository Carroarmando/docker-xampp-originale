load = false;

(async () => 
{
    if (!load)
    {
        candles = mescolaMazzo(candles, game_id);
        neighborhood = mescolaMazzo(neighborhood, game_id);
        demons = mescolaMazzo(demons, game_id);
    
        // sceglie la candela
        const candle_id = candles[i];
        await fetch(`../php/api/set/candle.php?candle=${candle_id}`);
    
        // demoni
        await demoni(i);
    
        load = true;
    }
})();


async function demoni(i) 
{
    if (i == 0) 
    {
        const demons_id = await get_demon(3);
        set_demons_offset(3);

        demons_id.forEach(demon_id => 
        {
            fetch(`../php/api/set/demon.php?demon=${demon_id}&summoned=0`);
        });
    } 
    else 
    {
        while (true)
        {
            if (get_demons_offset() == 3)
                break;
            await new Promise(r => setTimeout(r, 500)); 
        }

        const demons_id = await get_demon(3);
        set_demons_offset(3);

        demons_id.forEach(demon_id => 
        {
            fetch(`../php/api/set/demon.php?demon=${demon_id}&summoned=0`);
        });
    }
}