<p>Новая заявка на подписку:</p>
<p>Имя: {{ $order->name }}</p>
<p>Телефон: {{ $order->phone }}</p>
<p>Email: {{ $order->email }}</p>
<p>Тип подписки: {{ $order->subscription_type }}</p>
<p>Клиент: {{ $order->customer_type === 'individual' ? 'Физ. лицо' : 'Юр. лицо' }}</p>
