# Apedik_PasswordAttributes module

This Magento module adds password attributes to `<input type"password">` element, eg:

```<input type"password" minlength="8" pattern="[0-9A-Z]"  autocomplete="new-password" >```

This is very useful for password managers and browsers to suggest the right password based on password requirements in Magento Password Options and, hopefully, improving conversions too.

For reference: https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/password

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
