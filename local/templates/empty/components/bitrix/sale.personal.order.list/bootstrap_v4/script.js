BX.namespace('BX.Sale.PersonalOrderComponent');

(function () {
	BX.Sale.PersonalOrderComponent.PersonalOrderList = {
		init: function (params) {
			var rowWrapper = document.getElementsByClassName('orders__item');

			params.paymentList = params.paymentList || {};
			params.url = params.url || "";
			params.templateName = params.templateName || "";
			params.returnUrl = params.returnUrl || "";

			Array.prototype.forEach.call(rowWrapper, function (wrapper) {
				BX.bindDelegate(wrapper, 'click', {'class': 'orders__item-descr-link'}, BX.proxy(function (event) {
					event.preventDefault();

					var block = wrapper.getElementsByClassName('sale-order-list-inner-row-body')[0];
					var template = wrapper.getElementsByClassName('sale-order-list-inner-row-template')[0];
					var cancelPaymentLink = template.getElementsByClassName('sale-order-list-cancel-payment')[0];

					BX.ajax(
						{
							method: 'POST',
							dataType: 'html',
							url: params.url,
							data:
								{
									sessid: BX.bitrix_sessid(),
									orderData: params.paymentList[event.target.id],
									templateName: params.templateName
								},
							onsuccess: BX.proxy(function (result) {
								var resultDiv = document.createElement('div');
								resultDiv.innerHTML = result;
								template.insertBefore(resultDiv, cancelPaymentLink);
								event.target.style.display = 'none';
								block.parentNode.removeChild(block);
								template.style.display = 'block';
								BX.bind(cancelPaymentLink, 'click', function () {
									window.location.reload();
								}, this);

							}, this),
							onfailure: BX.proxy(function () {
								return this;
							}, this)
						}, this
					);

				}, this));
			});
		}
	};
})();