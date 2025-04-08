console.log("fetchData");

import { doQuery } from './export/query.js';
import { populate } from './export/populate.js';

let doQuery = "select * from users";

async function fetchData() 
{
    try 
    {
        data = doQuery(doQuery);
        populate(data);
    }
    catch(err) { }
}

setInterval(fetchData, 500);