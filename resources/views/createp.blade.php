<form action="{{ route('produit.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name">Nom du produit:</label>
    <input type="text" name="name" required>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea>

    <label for="price">Prix:</label>
    <input type="number" name="price" step="0.01" required>

    <label for="image">Image:</label>
    <input type="file" name="image_path" accept="image/*" required>

    <button type="submit">Ajouter le produit</button>
</form>
