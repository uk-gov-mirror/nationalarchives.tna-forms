/**
 * THE NATIONAL ARCHIVES
 * ------------------------------------------------------------------------------
 * Newsletter JQuery validation tests
 * ------------------------------------------------------------------------------
 * 1. Checking the DOM before plugin is applied
 * 2. Checking the custom utilities created for this plugin
 * 3. State of the DOM after the plugin has run
 * 4. State of the DOM in response to user interactions
 * 5. If an invalid string is provided, the submit button should be disabled again
 * 6. If an empty string is provided, the submit button should be disabled again
 */


/**
 * 1. Checking the DOM before plugin is applied
 */
QUnit.module("Checking the mandatory DOM elements before plugin is applied", function () {
    QUnit.test("Check required elements in fixture", function (assert) {
        assert.ok($('form', '.fixture').length == 1, "The form is present");
        assert.ok($('form#records-research-enquiry', '.fixture').length == 1, "The form ID is present");
        assert.ok($('input[type=submit]', '.fixture').prop('disabled') == false, "The submit button is NOT disabled before the plugin has run");
        assert.equal($('input[type=hidden]', '.fixture').attr('name'), "tna-form", "The input type hidden field with the attribute name of tna-form is present");
    });
});

/**
 * 1. Checking the Fields before plugin is applied
 */
QUnit.module("Checking the fields before plugin is applied", function () {
    QUnit.test("Check required elements in fixture", function (assert) {
        assert.ok($('#full_name', '.fixture').length == 1, "The full_name input is present");
        assert.ok($('#email', '.fixture').length == 1, "The email input is present");
        assert.equal($('#email', '.fixture').val(), "", "The email address is empty");
        assert.ok($('#confirm_email', '.fixture').length == 1, "The confirm email input is present");
        assert.equal($('#confirm_email', '.fixture').val(), "", "The confirm email address is empty");
        assert.ok($('#enquiry', '.fixture').length == 1, "The enquiry textarea is present");
        assert.ok($('#country', '.fixture').length == 1, "The country input is present");
        assert.ok($('#dates', '.fixture').length == 1, "The dates input is present");
        assert.equal($('#submit-tna-form', '.fixture').attr('name'), "submit-rre", "Name on input button is submit-rre");
    });
});