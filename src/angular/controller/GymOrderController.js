'use strict';
userApp.controller('GymOrderController', ['$scope', '$timeout', 'Membership', 'Cart', function($sc, $timeout, Membership, Cart) {
    $sc.cart_data = [];
    $sc.cart_count = 0;
    $sc.total_price = 0;
    $sc.user_id = '';

    $sc.orders_data = [];
    $sc.orders_total = 0;

    $sc.paymentType = "0";
    $sc.gcashPaymentFlg = 0;

    $sc.initCart = function(user_id) {
        $sc.user_id = user_id;
        $sc.fetchCartList();
    };

    $sc.selectPaymentType = function (type) {
		$sc.gcashPaymentFlg = type;
    };

    $sc.fetchCartList = function() {
        var request = { user_id: $sc.user_id };
        Cart.carList(request)
            .then(function(res) {
                if (!!res.success) {
                    $sc.cart_data = res.data;
                    $sc.cart_count = res.total_count;
                    $sc.calculateTotalPrice();
                }
            })
            .fail(function(err) {
                console.error('CART ~ ERROR: ', err);
            })
            .always(function() {
                $sc.$apply();
            });
    };

    $sc.addToCart = function(product) {
        if (product.is_verify_flg == 0) {
            var swalParam = {
				icon: 'info',
				title: 'COMPLETE YOUR PROFILE',
				html: 'Update your profile to avail membership plan.',
				link: 'settings.php',
			};
			SwalAlert(swalParam);

			return;
        }

        var request = {
            user_id: product.user_id,
            product_id: product.id,
            price: product.price,
            quantity: product.get_qty,
        };

        $sc.user_id = product.user_id;

        Cart.addToCart(request)
            .then(function(res) {
                if (!!res.success) {
                    var swalParam = {
                        icon: "success",
                        title: "ADDED TO CART",
                        html: "Product is already added in your cart",
                        link: "cart.php",
                    };
                    SwalAlert(swalParam);
                } else {
                    Swal.fire({
                        icon: "info",
                        title: "DUPLICATE",
                        text: "Product is already in your cart",
                    });
                }
            })
            .fail(function(err) {
                console.error("CART ~ ERROR: ", err);
            })
            .always(function() {
                $sc.$apply();
            });
    };

    $sc.increaseQuantity = function(cartItem) {
        if (parseInt(cartItem.quantity) < parseInt(cartItem.product_qty)) {
            cartItem.quantity++;
            $sc.updateCart(cartItem);
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Maximum Quantity Reached',
                text: `You can only add up to ${cartItem.product_qty} of this product.`,
            });
        }
    };

    $sc.decreaseQuantity = function(cartItem) {
        if (parseInt(cartItem.quantity) > 1) {
            cartItem.quantity--;
            $sc.updateCart(cartItem);
        }
    };

    $sc.updateCart = function(cartItem) {
        var request = {
            user_id: $sc.user_id,
            product_id: cartItem.product_id,
            quantity: cartItem.quantity,
        };

        Cart.updateCart(request)
        .then(function(res) {
           console.log('UPDATE QTY ~ ', res);
        })
        .fail(function(err) {
            console.error("Update Cart Error: ", err);
        });
    };

    $sc.calculateTotalPrice = function() {
        $sc.total_price = $sc.cart_data.reduce(function(total, item) {
            return total + item.price * item.quantity;
        }, 0);
    };

    $sc.deleteToCart = function(cartItem) {
        var param = {
            cart_id: cartItem.id
        }

        Cart.removeToCart(param)
        .then(function(res) {
           console.log('REMOVE PRODUCT ~ ', res);
           if (!!res.success) {
                Swal.fire({
                    icon: "success",
                    title: "REMOVED TO CART",
                    text: "Product has been removed to your cart",
                    timer: 1000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = "cart.php";
                    },
                });
           }
        })
        .fail(function(err) {
            console.error("REMOVE PRODUCT: ", err);
        });
    }

    $sc.checkOutProduct = function() {

		if ($("input[name='payment_type']:checked").val() == 1) {
			var checkReceipt = $("input[name='receipt']")[0].files[0];
            var gcashNo = $("input[name='gcash_no']").val();
			var checkReferenceNo = $("input[name='reference_no']").val();

            if (!gcashNo || (!checkReceipt && !checkReferenceNo)) {
				Swal.fire({
					icon: "error",
					title: "FAILED PROCESS",
					text: "Provide atleast GCash receipt or Reference No.",
				});
				return;
			}
		}

        var commonParams = {
            order_code: generateOrderCode(),
            order_status: 1,
            payment_type: $sc.gcashPaymentFlg,
        };
        
        $.each($sc.cart_data, function(index, item) {
            var checkoutParams = {
                ...commonParams,
                cart_id: item.id,
                user_id: item.user_id,
                product_id: item.product_id,
                quantity: item.quantity,
                product_qty: item.product_qty,
                price: item.price
            };

            Cart.checkOut(checkoutParams)
            .then(function(res) {
                console.log('CHEKCOUT: ', res);
            })
            .catch(function(err) {
                console.error('ERROR:', err);
            });
        });

        $sc.checkOutTransaction(commonParams);
    };

    $sc.checkOutTransaction = function(params) {
        var formData = new FormData();
        formData.append('user_id', $sc.user_id);
        formData.append('order_code', params.order_code);
        formData.append('order_status', params.order_status);
        formData.append('payment_type', params.payment_type);
        formData.append('amount', $sc.total_price);
        
        var receiptFile = $("input[name='receipt']")[0].files[0];
        var referenceNo = $("input[name='reference_no']").val();
        var gcashNo = $("input[name='gcash_no']").val(); 

        if (receiptFile) {
            formData.append('receipt', receiptFile);
        }
        formData.append('reference_no', referenceNo);
        formData.append('gcash_no', gcashNo);+
    
        Cart.checkOutTransaction(formData)
        .then(function(res) {
            console.log('TRANS: ', res);

            if (res.data.success) {
                var swalParam = {
                    icon: "success",
                    title: "CHECKOUT PRODUCT",
                    html: "Successfully checkout, check in purchases page to see the status",
                    link: "my-purchase.php",
                };
                SwalAlert(swalParam);
            }
        })
        .catch(function(err) {
            console.error('ERROR:', err);
        });
    };

    $sc.orderDetails = function(detail) {
        console.warn('DETAILS: ', detail);

        var params = {
            order_code: detail.order_code,
        }
        
        Cart.orderDetails(params)
        .then(function(res) {
            console.log(res);

            if (res.success) {
                $sc.orders_data = res.data;
                $sc.orders_total = res.total_count;

                $sc.calcOrderTotal();
            }
        })
        .fail(function(err) {
            console.error("CART ~ ERROR: ", err);
        })
        .always(function() {
            $sc.$apply();
        });
    }

    $sc.arr_order_data = [];
    $sc.adminOrderDetails = function(detail) {
        $sc.arr_order_data = detail;

        console.warn('DETAILS: ', $sc.arr_order_data);

        var params = {
            order_code: detail.order_code,
        }
        
        Cart.adminOrderDetails(params)
        .then(function(res) {
            console.log(res);

            if (res.success) {
                $sc.orders_data = res.data;
                $sc.orders_total = res.total_count;

                $sc.calcOrderTotal();
            }
        })
        .fail(function(err) {
            console.error("CART ~ ERROR: ", err);
        })
        .always(function() {
            $sc.$apply();
        });
    }

    $sc.calcOrderTotal = function() {
        $sc.totalQuantity = 0;
        $sc.totalPrice = 0;
    
        angular.forEach($sc.orders_data, function(order) {
            var quantity = parseInt(order.quantity, 10) || 0;
            var price = parseFloat(order.price) || 0;

            $sc.totalQuantity += quantity;
            $sc.totalPrice += price * quantity;
        });
    };

    $sc.orderChangeStatus = function(order_status, payment_status) {
        var params = {
            order_code: $sc.arr_order_data.order_code,
            order_status: order_status,
            payment_status: payment_status,
            amount_recieved: $sc.totalPrice,
        }

        console.warn(params);

        Cart.orderStatusChange(params)
        .then(function(res) {
            console.log('LOG: ',res);
            if (res.success) {

                var setIcon = "";
                var setTitle = "";
                var setHtml = "";

                if (order_status == 2) {
                    setIcon = "success";
                    setTitle = "ORDER PREPARED";
                    setHtml = "Done repared this order and ready for pickup";
                }
                
                if (order_status == 3) {
                    setIcon = "success";
                    setTitle = "ORDER COMPLETED";
                    setHtml = "Order was already pickup by the user";
                }

                if (order_status == 4) {
                    setIcon = "error";
                    setTitle = "ORDER CANCELLED";
                    setHtml = "Order was already Cancelled";
                }

                var swalParam = {
                    icon: setIcon,
                    title: setTitle,
                    html: setHtml,
                    link: "orders.php?order_code=" + $sc.arr_order_data.order_code,
                };
                SwalAlert(swalParam);
            }
        })
        .fail(function(err) {
            console.error("CART ~ ERROR: ", err);
        })
        .always(function() {
            $sc.$apply();
        });
    }

    function generateOrderCode() {
        var randomStr = crypto.getRandomValues(new Uint8Array(3))
            .map(byte => byte.toString(16).padStart(2, '0'))
            .join('')
            .toUpperCase()
            .substring(0, 3); 
    
        var randomDigits = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
        var transactionCode = `PRDCT_ORD_${randomStr}${randomDigits}`;
    
        return transactionCode;
    }
    

    function SwalAlert(data) {
        console.warn(data);

        let timerInterval;
        Swal.fire({
            icon: data.icon,
            title: data.title,
            html: data.html,
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();

                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                    timer.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                }, 1000);
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                window.location.href = data.link;
            }
        });
    }

}]);
