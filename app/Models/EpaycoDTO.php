<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpaycoDTO
{
    private $bank;
    private $invoice;
    private $description;
    private $value;
    private $tax;
    private $taxBase;
    private $currency;
    private $typePerson;
    private $docType;
    private $docNumber;
    private $name;
    private $lastName;
    private $email;
    private $country;
    private $cellPhone;
    private $ip;
    private $urlResponse;
    private $urlConfirmation;
    private $methodsConfirmation;

    /**
     * @return mixed
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param mixed $bank
     */
    public function setBank($bank): void
    {
        $this->bank = $bank;
    }

    /**
     * @return mixed
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @param mixed $invoice
     */
    public function setInvoice($invoice): void
    {
        $this->invoice = $invoice;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param mixed $tax
     */
    public function setTax($tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return mixed
     */
    public function getTaxBase()
    {
        return $this->taxBase;
    }

    /**
     * @param mixed $taxBase
     */
    public function setTaxBase($taxBase): void
    {
        $this->taxBase = $taxBase;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getTypePerson()
    {
        return $this->typePerson;
    }

    /**
     * @param mixed $typePerson
     */
    public function setTypePerson($typePerson): void
    {
        $this->typePerson = $typePerson;
    }

    /**
     * @return mixed
     */
    public function getDocType()
    {
        return $this->docType;
    }

    /**
     * @param mixed $docType
     */
    public function setDocType($docType): void
    {
        $this->docType = $docType;
    }

    /**
     * @return mixed
     */
    public function getDocNumber()
    {
        return $this->docNumber;
    }

    /**
     * @param mixed $docNumber
     */
    public function setDocNumber($docNumber): void
    {
        $this->docNumber = $docNumber;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    /**
     * @param mixed $cellPhone
     */
    public function setCellPhone($cellPhone): void
    {
        $this->cellPhone = $cellPhone;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getUrlResponse()
    {
        return $this->urlResponse;
    }

    /**
     * @param mixed $urlResponse
     */
    public function setUrlResponse($urlResponse): void
    {
        $this->urlResponse = $urlResponse;
    }

    /**
     * @return mixed
     */
    public function getUrlConfirmation()
    {
        return $this->urlConfirmation;
    }

    /**
     * @param mixed $urlConfirmation
     */
    public function setUrlConfirmation($urlConfirmation): void
    {
        $this->urlConfirmation = $urlConfirmation;
    }

    /**
     * @return mixed
     */
    public function getMethodsConfirmation()
    {
        return $this->methodsConfirmation;
    }

    /**
     * @param mixed $methodsConfirmation
     */
    public function setMethodsConfirmation($methodsConfirmation): void
    {
        $this->methodsConfirmation = $methodsConfirmation;
    }

    public function toArray(): array
    {
        return [
            'bank' => $this->getBank(),
            'invoice' => $this->getInvoice(),
            'description' => $this->getDescription(),
            'value' => $this->getValue(),
            'tax' => $this->getTax(),
            'tax_base' => $this->getTaxBase(),
            'currency' => $this->getCurrency(),
            'type_person' => $this->getTypePerson(),
            'doc_type"' => $this->getDocType(),
            'doc_number' => $this->getDocNumber(),
            'name' => $this->getName(),
            'last_name' => $this->getLastName(),
            'email' => $this->getEmail(),
            'country' => $this->getCountry(),
            'cell_phone' => $this->getCellPhone(),
            'ip' => $this->getIp(),
            'url_response' => $this->getUrlResponse(),
            'url_confirmation' => $this->getUrlConfirmation(),
            'metodoconfirmacion' => $this->getMethodsConfirmation()
        ];
    }
}
