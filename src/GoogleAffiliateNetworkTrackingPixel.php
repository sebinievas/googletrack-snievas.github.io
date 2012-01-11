<?php

/**
* Simple class for generating a Google Affiliate Network tracking pixel
* 
* @author Sebastian Nievas
*/
class GoogleAffiliateNetworkTrackingPixel
{
	protected $advertiserId = null;
	protected $itemList = array();
	protected $orderId = null;
	protected $orderAmount = 0;
	protected $clickId = null;
	protected $clickIdParameterName = 'clickid';
	protected $eventType = 'transaction';
	protected $currencyCode = 'USD';
	protected $className = 'gan';
	
	public function __construct($advertiser_id = null)
	{
		$this->setAdvertiserId($advertiser_id);
	}
	
	public function setAdvertiserId($advertiser_id)
	{
		$this->advertiserId = $advertiser_id;
	}
	
	public function getAdvertiserId()
	{
		return $this->advertiserId;
	}
	
	public function setClassName($class_name)
	{
		$this->className = $class_name;
	}
	
	public function getClassName()
	{
		return $this->className;
	}
	
	public function setClickIdParameterName($name)
	{
		$this->clickIdParameterName = $name;
	}
	
	public function getClickIdParameterName()
	{
		return $this->clickIdParameterName;
	}
	
	public function setClickId($click_id)
	{
		$this->clickId = $click_id;
	}
	
	public function getClickId()
	{
		return $this->clickId;
	}
	
	public function setOrderId($order_id)
	{
		$this->orderId = $order_id;
	}
	
	public function getOrderId()
	{
		return $this->orderId;
	}
	
	public function setOrderAmount($order_amount)
	{
		$this->orderAmount = $order_amount;
	}
	
	public function getOrderAmount()
	{
		return $this->orderAmount;
	}
	
	public function setEventType($event_type)
	{
		$this->eventType = $event_type;
	}
	
	public function getEventType()
	{
		return $this->eventType;
	}
	
	public function setCurrencyCode($currency_code)
	{
		$this->currencyCode = $currency_code;
	}
	
	public function getCurrencyCode()
	{
		return $this->currencyCode;
	}
	
	public function addItem($sku, $price, $quantity, $category_id = null)
	{
		$this->itemList[$sku] = array(
			'sku' => $sku,
			'price' => $price,
			'quantity' => $quantity
		);
		
		if (!is_null($category_id))
		{
			$this->itemList[$sku]['category_id'] = $category_id;
		}
	}
	
	public function getTrackingCode()
	{
		$sku_list = array();
		$price_list = array();
		$quantity_list = array();
		$category_list = array();
		
		foreach ($this->itemList as $item)
		{
			$sku_list[]      = $item['sku'];
			$price_list[]    = $item['price'];
			$quantity_list[] = $item['quantity'];
			
			if (isset($item['category_id']))
			{
				$category_list[] = $item['category_id'];
			}
		}
		
		$html = '<img src="https://gan.doubleclick.net/gan_conversion?'
			.'advid='.$this->getAdvertiserId()
			.'&oid='.$this->getOrderId()
			.'&amt='.$this->getOrderAmount()
			.'&fxsrc='.$this->getCurrencyCode()
				.((empty($sku_list))      ? '' : '&prdsku='  .implode('^', $sku_list))
				.((empty($price_list))    ? '' : '&prdpr='   .implode('^', $price_list))
				.((empty($quantity_list)) ? '' : '&prdqn='   .implode('^', $quantity_list))
				.((empty($category_list)) ? '' : '&prdcatid='.implode('^', $category_list))
			.'&event_type='.$this->getEventType()
			.'&clickid='.$this->getClickId()
			.'" class="'.$this->getClassName().'" width="1" height="1" />';
		
		return $html;
	}
}

