.. _terminals:

#########
Terminals
#########

The section **Client configuration** > **Terminals** allows creating new
SIP credentials that can be used by multiple SIP devices to place and receive
calls from IvozProvider.

The best way to understand this section is creating a new item and see the 
fields that must be filled.

    Name
        Username that will use the terminal during the SIP authentication phase
        with IvozProvider.

    Password
        Password that will use the terminal to answer the SIP authentication
        challenge. You can use the automatic password generator to fulfill the
        secure password requirements.

    Allowed/Disallowed codecs
        Determines what audio and video codecs will be used with the terminal.

    CallerID update method
        Choose the SIP method the terminal prefers to received the session
        update information: INVITE or UPDATE. The help hint can be used as
        guide to configure different terminal manufacturers. Use *INVITE* in 
        case of doubt.

    Terminal model
        Determines the provisioning type that will receive this terminal.
        The section :ref:`terminal provisioning <provisioning>` will explain
        in depth the different models for automatic provision. If your device
        does not require provisioning, just select *Generic*.

    MAC
        Optional field that is only required if you plan to use IvozProvider 
        :ref:`terminal provisioning <provisioning>`. This is the `physical
        address <https://wikipedia.org/wiki/MAC_Address>`_ of the network 
        adapter of the SIP device.

    Enable T.38 passthrough
        If set to 'yes', this SIP endpoint must be a **T.38 capable fax sender/receiver**. IvozProvider
        will act as a T.38 gateway, bridging fax-calls of a T.38 capable carrier and a T.38 capable device.

    RTP Encryption
        If set to 'yes', call won't be established unless it's possible to encryption its audio. If set to 'no',
        audio won't be encrypted.

.. note:: For **most of devices** that doesn't require provisioning just
   filling **username** and **password** will be enough.

.. hint:: Once the terminal has been created, most devices will only
   require the name, password and :ref:`Client SIP domain <domain_per_client>` 
   in order to place calls.
