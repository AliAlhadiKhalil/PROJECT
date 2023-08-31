using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;

namespace CVproject.Data
{
    public class CV
    {
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Key]
        public int Id { get; set; }
        public String FirstName { get; set; }
        public String LastName { get; set; }
        public DateTime DateOfBirth { get; set; }
        public String Nationality { get; set; }
        public String Gender { get; set; }
        public String Email { get; set; }
        public String Photo { get; set; }
        public String Skills { get; set; }
    }
}
