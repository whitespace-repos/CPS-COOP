// 
var table = "";
var json = {};
const getRecords = async (options = { maxRecords: 13, view: 'Grid view' }) => {
    const records = await table
        .select(options)
        .firstPage();
    return records;    
};

const minifyRecord = (record) => {
    return {
        id: record.id,
        fields: record.fields,
    };
};

const createRecord = async (fields) => {
    const createdRecord = await table.create(fields);
    return minifyRecord(createdRecord);
};

const updateRecord = async (id, fields) => {
    const updatedRecord = await table.update(id, fields);
    return minifyRecord(updatedRecord);
};

const deleteRecord = async (id) => {
    const deletedRecord = await table.destroy(id);
    return minifyRecord(deletedRecord);
};

const getRecordById = async (id) => {
    return await table.find(id);    
};


//let resolvePromise =
