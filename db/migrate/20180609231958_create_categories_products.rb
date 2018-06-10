class CreateCategoriesProducts < ActiveRecord::Migration[5.2]
  def change
    create_table :categories_products do |t|
      t.references :category
      t.references :product
    end
  end
end
