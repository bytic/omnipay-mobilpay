<?php

namespace ByTIC\Omnipay\Mobilpay\Tests\Models\Soap;

use ByTIC\Omnipay\Mobilpay\Models\Soap\Contact;
use ByTIC\Omnipay\Mobilpay\Models\Soap\ContactList;
use ByTIC\Omnipay\Mobilpay\Models\Soap\Person;
use ByTIC\Omnipay\Mobilpay\Models\Soap\User;
use ByTIC\Omnipay\Mobilpay\Tests\AbstractTest;

/**
 * Class UserTest
 * @package ByTIC\Omnipay\Mobilpay\Tests\Models\Soap
 */
class UserTest extends AbstractTest
{
    public function test_fromArray()
    {
        $data = [
            'username' => 'test',
            'password' => 'test-pass#123',
            'person' => [
                'first_name' => 'John',
                'last_name' => 'Foe',
                'contacts' => [
                    'phone' => '0741000222',
                    'email' => 'test@galantom.ro',
                ],
                'type' => Person::TYPE_TEHNICAL,
            ],
        ];

        $user = User::fromArray($data);

        self::assertInstanceOf(User::class, $user);
        self::assertSame($data['username'], $user->getUsername());
        self::assertSame($data['password'], $user->getPassword());

        $person = $user->getPerson();
        self::assertInstanceOf(Person::class, $person);
        self::assertSame($data['person']['first_name'], $person->getFirstName());
        self::assertSame($data['person']['last_name'], $person->getLastName());

        $contacts = $person->getContacts();
        self::assertInstanceOf(ContactList::class, $contacts);

        /** @var Contact $contact */
        $contactsArray = $contacts->getItems();
        $contact = reset($contactsArray);
        self::assertInstanceOf(Contact::class, $contact);
        self::assertSame($data['person']['contacts']['phone'], $contact->getPhone());
        self::assertSame($data['person']['contacts']['email'], $contact->getEmail());

        $data['person']['contacts'] = [$data['person']['contacts']];
        $data['id'] = null;
        self::assertSame($data, $user->toArray());
    }
}
