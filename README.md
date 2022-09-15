## **Table of Contents**

1. [Overview](#overview)

2. [Supported Authentication
Methods](#supported-authentication-methods)

3. [Installation and Configuration](#installation-and-configuration)

4. [Troubleshooting](#troubleshooting)

<a id="overview"></a>
## 1\. Overview

Rublon MFA for Roundcube is a connector that enables Multi-Factor
Authentication (MFA) / Two-Factor Authentication (2FA) during user
logins.

Rublon adds an extra layer of security by prompting the user to
authenticate using an extra authentication method such as [Mobile
Push](https://rublon.com/product/mobile-push/). Even if a
malicious actor compromises the user\'s password, the hacker would not
be able to log in to the user\'s account because the second secure
factor will thwart them.

Rublon adds an extra layer of security **when a user signs in to a
system** (after the user enters the correct password).

When a user signs in to a system, the second authentication factor
should be initiated only after:

1.  The user has successfully completed the first authentication factor
    > (e.g., entered the correct password)

2.  The user\'s unique Id and email address have been gathered

<a id="supported-authentication-methods"></a>
## 2\. Supported Authentication Methods

- [Mobile Push](https://rublon.com/product/mobile-push/) 
    > approve the authentication request by tapping a push notification
     on the Rublon Authenticator mobile app.

- [Mobile Passcodes](https://rublon.com/product/mobile-passcodes/) (TOTP)
    > enter the TOTP code (Time-Based One Time Password) using
     the Rublon Authenticator mobile app.

- [SMS Passcodes](https://rublon.com/product/sms-passcodes/)
    > enter the verification code from the SMS sent to your mobile
     phone.

- [QR Codes](https://rublon.com/product/qr-codes/)
    > scan a QR code using the Rublon Authenticator mobile app.

- [WebAuthn/U2F Security Keys](https://rublon.com/product/security-keys/)
    > insert and touch your FIDO2-compliant security key.

<a id="installation-and-configuration"></a>
## 3\. Installation and Configuration

For detailed step-by-step installation and configuration instructions,
refer to:
[https://rublon.com/doc/roundcube/](https://rublon.com/doc/roundcube/)

<a id="troubleshooting"></a>
## 4\. Troubleshooting

If you encounter any issues with your Rublon integration, please contact
[Rublon Support](https://rublon.com/support/).
