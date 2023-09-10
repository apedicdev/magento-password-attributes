# Apedik_PasswordAttributes module

This Magento module adds password attributes to `<input type"password">` element, eg:

```<input type"password" minlength="8" pattern="[0-9A-Z]"  autocomplete="new-password" >```

This is very useful for password managers and browsers to suggest the right password based on password requirements in Magento Password Options and, hopefully, improving conversions too.

For reference: https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/password

Apple Password rules: https://developer.apple.com/password-rules/

#### Configuration

Magento section`customer/password`:

<img src="https://images2.imgbox.com/9e/06/48dAltAs_o.png" alt=""/>

Configuration path to customer password required character classes number and Minimum Password Length: these are out of box Magento configuration. The module will generate the attributes, pattern and rules based on it.

Configuration path to enable password attributes: If set to Yes, password attributes will be added to `input type="password"` element.

Configuration path to add regex password attributes pattern: If set to Yes, password attribute pattern will be added to `input type="password"` element.

Configuration path to add password rules: If set to Yes, password rules will be added to `input type="password"` element.

When settings are disabled:
```
<input type="password" name="password" id="password" title="Password" class="input-text" data-password-min-length="8" data-password-min-character-sets="2" aria-required="true">
```

When settings are enabled:
```
<input type="password" name="password" id="password" title="Password" class="input-text" data-password-min-length="8" data-password-min-character-sets="2"
 minlength="8" autocomplete="new-password" required="" pattern="^(?=.*[A-Z])(?=.*\d).{8,}$" passwordrules="minlength: 8; required: digit; required: upper" aria-required="true">
```

Testing min. length 40 characters:

<img src="https://images2.imgbox.com/ae/1d/tKdWPWw5_o.png" alt="image host"/>

The suggested password will satisfy requirements.

MFTF support, for testing different password scenarios.

```
 vendor/bin/mftf run:test StorefrontCreateCustomer4CharsClassesTest

Generate Tests Command Run

Codeception PHP Testing Framework v5.0.11 https://helpukrainewin.org

Magento\FunctionalTestingFramework.functional Tests (1) ------------------------
Modules: \Magento\FunctionalTestingFramework\Module\MagentoWebDriver, \Magento\FunctionalTestingFramework\Module\MagentoSequence, \Magento\FunctionalTestingFramework\Module\MagentoAssert, \Magento\FunctionalTestingFramework\Module\MagentoActionProxies, Asserts, \Magento\FunctionalTestingFramework\Helper\HelperContainer
--------------------------------------------------------------------------------
StorefrontCreateCustomer4CharsClassesTestCest: Storefront create customer4 chars classes test
Signature: Magento\AcceptanceTest\_default\Backend\StorefrontCreateCustomer4CharsClassesTestCest:StorefrontCreateCustomer4CharsClassesTest
Test: tests/functional/Magento/_generated/default/StorefrontCreateCustomer4CharsClassesTestCest.php:StorefrontCreateCustomer4CharsClassesTest
Scenario --
[START BEFORE HOOK]
[minDigitUpperLowercaseSpecialCharPassword] magento cli "config:set customer/password/required_character_classes_number 4",60
Value was saved.
[END BEFORE HOOK]
[openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup
  [goToCustomerAccountCreatePage] am on page "/customer/account/create/"
  [waitForPageLoaded] wait for page load 60
[fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup
  [fillFirstName] fill field "#firstname","John"
  [fillLastName] fill field "#lastname","Doe"
  [fillEmail] fill field "#email_address","64fe2906a6b99John.Doe@example.com"
  [fillPassword] fill field "#password","Asdfghj1!"
  [fillConfirmPassword] fill field "#password-confirmation","Asdfghj1!"
[submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup
  [waitForCreateAccountButtonIsActive] wait for page load 60
  [clickCreateAccountButton] click "button.action.submit.primary"
  [clickCreateAccountButtonWaitForPageLoad] wait for page load 30
  [waitForCustomerSaved] wait for page load 60
[seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup
  [verifyMessage] see "Thank you for registering with Main Website Store.","#maincontent .message-success"
 PASSED 

--------------------------------------------------------------------------------
Time: 00:09.844, Memory: 16.00 MB

OK (1 test, 1 assertion)

```
