var data = null;
var username = null;
var token = null;

function _ajax_request(url, data, callback, type, method) {
    if (jQuery.isFunction(data)) {
        callback = data;
        data = {};
    }
    return jQuery.ajax({
        type: method,
        url: url,
        data: data,
        success: callback,
        dataType: type,
        async: false
        });
}

$.extend({
	    put: function(url, data, callback, type) {
	        return _ajax_request(url, data, callback, type, 'PUT');
	    },
	    delete_: function(url, data, callback, type) {
	        return _ajax_request(url, data, callback, type, 'DELETE');
	    }
	});

$(document).ready(tests);

function tests(assert)
{
    QUnit.config.reorder = false;
    createUserTest();
    accessTest();
    blockCreateTest();
}

function createUserTest()
{
    QUnit.test('createUserTest', function(assert) {
        username = Date.now();
        post('../api/user/', {name:username, auth_client_salt:'1234567891234567891234', auth_client_hash:'68MBk3FUXTkwrQ9UULZDgGXB8g2I', enc_client_salt:'abcdefghijklmnopqrstuv'});
        assert.ok(data.hasOwnProperty('success'), JSON.stringify(data) + ' has property: success');
        assert.equal(data.success, true, 'successful');
        token = data.token;
    });
}

function accessTest()
{
    QUnit.test('accessTest', function(assert) {
        post('../api/access/', {name:username, auth_client_hash:'68MBk3FUXTkwrQ9UULZDgGXB8g2I'});
        assert.ok(data.hasOwnProperty('success'), JSON.stringify(data) + ' has property: success');
        assert.equal(data.success, true, 'successful');
        assert.ok(data.hasOwnProperty('token'), JSON.stringify(data) + ' has property: token');
        token = data.token;
    });
}

function blockCreateTest()
{
    QUnit.test('blockCreateTest', function(assert) {
        post('../api/block/', {data:'testdata'});
        assert.ok(data.hasOwnProperty('success'), JSON.stringify(data) + ' has property: success');
        assert.equal(data.success, true, 'successful');
        assert.ok(data.hasOwnProperty('block_id'), JSON.stringify(data) + ' has property: block_id');
        var block_id = data.block_id;

        //set as main block
        put('../api/user/main_block_id', {main_block_id:block_id});
        assert.ok(data.hasOwnProperty('success'), JSON.stringify(data) + ' has property: success');
        assert.equal(data.success, true, 'successful');

        //read block data
        get('../api/block/'+block_id);
        assert.ok(data.hasOwnProperty('success'), JSON.stringify(data) + ' has property: success');
        assert.equal(data.success, true, 'successful');
        assert.ok(data.hasOwnProperty('data'), JSON.stringify(data) + ' has property: data');
        assert.equal(data.data, 'testdata', 'data correct');

        //update block data
        put('../api/block/'+block_id, {data:'testdata_updated'});
        assert.ok(data.hasOwnProperty('success'), JSON.stringify(data) + ' has property: success');
        assert.equal(data.success, true, 'successful');

        //read updated block data
        get('../api/block/'+block_id);
        assert.ok(data.hasOwnProperty('success'), JSON.stringify(data) + ' has property: success');
        assert.equal(data.success, true, 'successful');
        assert.ok(data.hasOwnProperty('data'), JSON.stringify(data) + ' has property: data');
        assert.equal(data.data, 'testdata_updated', 'data correct');

        //delete block
        delete_('../api/block/'+block_id);
        assert.ok(data.hasOwnProperty('success'), JSON.stringify(data) + ' has property: success');
        assert.equal(data.success, true, 'successful');

        //set main_block to null
        put('../api/user/main_block_id/', {main_block_id:null});
        assert.ok(data.hasOwnProperty('success'), JSON.stringify(data) + ' has property: success');
        assert.equal(data.success, true, 'successful');
    });
}

function saveData(data_)
{
	data = data_;
}

function get(url)
{
    data = null;
	jQuery.ajax({
        type: 'GET',
        url: url,
        success: saveData,
        dataType: 'json',
        async: false,
        beforeSend: function (request)
        {
            request.setRequestHeader("TOKEN", token);
        }
    });
}

function post(url, postData)
{
    data = null;
    jQuery.ajax({
        type: 'POST',
        url: url,
        data: postData,
        success: saveData,
        dataType: 'json',
        async: false,
        beforeSend: function (request)
        {
            request.setRequestHeader("TOKEN", token);
        }
    });
}

function put(url, putData)
{
    data = null;
    jQuery.ajax({
        type: 'PUT',
        url: url,
        data: putData,
        success: saveData,
        dataType: 'json',
        async: false,
        beforeSend: function (request)
        {
            request.setRequestHeader("TOKEN", token);
        }
    });
}

function delete_(url)
{
    data = null;
    jQuery.ajax({
        type: 'DELETE',
        url: url,
        success: saveData,
        dataType: 'json',
        async: false,
        beforeSend: function (request)
        {
            request.setRequestHeader("TOKEN", token);
        }
    });
}