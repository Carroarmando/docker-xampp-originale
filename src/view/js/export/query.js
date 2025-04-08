console.log("query");

export async function doQuery(query)
{
    const formData = new FormData();
    formData.append("query", query);


    const response = await fetch("api/esegui_query.php", 
        {
            method: "POST",
            body: formData
        });

    const data = await response.json();
    return data;
}